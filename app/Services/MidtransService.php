<?php

namespace App\Services;

use App\Models\Transaction;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function createSnapTransaction(Transaction $transaction): object
    {
        $transaction->loadMissing(['user', 'details.product']);

        $grossAmount = (int) round($transaction->grand_total);
        $expiryStartTime = now()->format('Y-m-d H:i:s O');

        $params = [
            'transaction_details' => [
                'order_id' => $transaction->midtrans_order_id,
                'gross_amount' => $grossAmount,
            ],
            'customer_details' => [
                'first_name' => $transaction->recipient_name,
                'email' => $transaction->user->email,
                'phone' => $transaction->recipient_phone,
            ],
            'item_details' => $this->buildItemDetails($transaction, $grossAmount),
            'expiry' => [
                'start_time' => $expiryStartTime,
                'unit' => 'hour',
                'duration' => 24,
            ]
        ];

        return Snap::createTransaction($params);
    }

    public function getSnapToken(Transaction $transaction): string
    {
        try {
            $response = $this->createSnapTransaction($transaction);
            return $response->token;
        } catch (\Exception $e) {
            Log::error('Midtrans getSnapToken error: ' . $e->getMessage());
            
            $grossAmount = (int) round($transaction->grand_total);
            return Snap::getSnapToken([
                'transaction_details' => [
                    'order_id' => $transaction->midtrans_order_id,
                    'gross_amount' => $grossAmount,
                ],
                'customer_details' => [
                    'first_name' => $transaction->recipient_name,
                    'email' => $transaction->user->email,
                    'phone' => $transaction->recipient_phone,
                ],
                'item_details' => $this->buildItemDetails($transaction, $grossAmount),
            ]);
        }
    }

    public function syncTransactionStatus(Transaction $transaction): Transaction
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = config('midtrans.is_3ds');

        try {
            $statusResponse = \Midtrans\Transaction::status($transaction->midtrans_order_id);
            if ($statusResponse) {
                // If statusResponse is returned as an array or object, we cast it
                $statusData = is_array($statusResponse) ? (object) $statusResponse : $statusResponse;
                
                $statusObj = (object) [
                    'transaction_status' => $statusData->transaction_status ?? '',
                    'fraud_status' => $statusData->fraud_status ?? null,
                    'transaction_id' => $statusData->transaction_id ?? null,
                    'payment_type' => $statusData->payment_type ?? null,
                ];

                $this->applyNotificationToTransaction($transaction, $statusObj);
            }
        } catch (\Exception $e) {
            Log::warning('Midtrans syncTransactionStatus error: ' . $e->getMessage(), [
                'order_id' => $transaction->midtrans_order_id
            ]);

            // If we get a 404 (transaction not found at Midtrans) and local order is pending and expired,
            // we should mark it as expired locally to prevent infinite pending status.
            if ($transaction->isPaymentExpired()) {
                $this->applyExpiredStatus($transaction);
            }
        }

        return $transaction->fresh();
    }

    public function applyExpiredStatus(Transaction $transaction): void
    {
        if ($transaction->status === 'pending') {
            $oldPaymentStatus = $transaction->payment_status;
            
            $transaction->update([
                'payment_status' => 'expired',
                'status' => 'expired',
            ]);
            
            $this->restoreStock($transaction);

            if ($oldPaymentStatus !== 'expired') {
                $transaction->loadMissing('user');
                \App\Models\Notification::create([
                    'user_id' => $transaction->user_id,
                    'title' => 'Pesanan Kadaluarsa ⏰',
                    'message' => "Batas waktu pembayaran pesanan #{$transaction->invoice_number} telah habis. Pesanan dibatalkan otomatis.",
                    'type' => 'info',
                    'link' => route('transactions.show', $transaction->id),
                    'is_read' => false,
                ]);
            }
        }
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function buildItemDetails(Transaction $transaction, int $grossAmount): array
    {
        $items = [];

        foreach ($transaction->details as $detail) {
            $items[] = [
                'id' => (string) $detail->product_id,
                'price' => (int) round($detail->price),
                'quantity' => (int) $detail->quantity,
                'name' => $this->sanitizeItemName($detail->product->name ?? 'Produk'),
            ];
        }

        if ((int) round($transaction->shipping_cost) > 0) {
            $items[] = [
                'id' => 'shipping',
                'price' => (int) round($transaction->shipping_cost),
                'quantity' => 1,
                'name' => 'Ongkos Kirim',
            ];
        }

        $itemsTotal = collect($items)->sum(fn (array $item) => $item['price'] * $item['quantity']);

        if ($itemsTotal !== $grossAmount && count($items) > 0) {
            $diff = $grossAmount - $itemsTotal;
            $items[count($items) - 1]['price'] += $diff;
        }

        if (empty($items)) {
            $items[] = [
                'id' => 'order',
                'price' => $grossAmount,
                'quantity' => 1,
                'name' => 'Pesanan ' . $transaction->invoice_number,
            ];
        }

        return $items;
    }

    private function sanitizeItemName(string $name): string
    {
        return mb_substr(preg_replace('/[^\pL\pN\s\-_.]/u', '', $name) ?: 'Produk', 0, 50);
    }

    /**
     * Proses HTTP notification dari Midtrans (webhook).
     * Tidak memakai Midtrans\Notification karena tidak kompatibel dengan Request Laravel.
     */
    public function handleNotification(?string $rawPayload = null): ?Transaction
    {
        if ($rawPayload === null || $rawPayload === '') {
            $rawPayload = file_get_contents('php://input') ?: '';
        }

        $payload = json_decode($rawPayload, true);

        if (! is_array($payload) || empty($payload)) {
            throw new \InvalidArgumentException('Invalid Midtrans notification payload');
        }

        $this->verifySignature($payload);

        $orderId = $payload['order_id'] ?? null;

        if (! $orderId) {
            throw new \InvalidArgumentException('order_id missing in Midtrans notification');
        }

        $transaction = Transaction::where('midtrans_order_id', $orderId)
            ->orWhere('invoice_number', $orderId)
            ->first();

        if (! $transaction) {
            Log::warning('Midtrans notification: transaksi tidak ditemukan', ['order_id' => $orderId]);

            return null;
        }

        $notif = (object) [
            'transaction_status' => $payload['transaction_status'] ?? '',
            'fraud_status' => $payload['fraud_status'] ?? null,
            'transaction_id' => $payload['transaction_id'] ?? null,
            'payment_type' => $payload['payment_type'] ?? null,
        ];

        $this->applyNotificationToTransaction($transaction, $notif);

        Log::info('Midtrans notification processed', [
            'order_id' => $orderId,
            'transaction_status' => $notif->transaction_status,
            'payment_status' => $transaction->fresh()->payment_status,
        ]);

        return $transaction;
    }

    /**
     * Verifikasi signature_key dari Midtrans.
     *
     * @see https://docs.midtrans.com/docs/https-notification-webhooks
     */
    private function verifySignature(array $payload): void
    {
        $signatureKey = $payload['signature_key'] ?? '';

        if ($signatureKey === '') {
            return;
        }

        $serverKey = config('midtrans.server_key');

        if ($serverKey === '' || $serverKey === null) {
            throw new \RuntimeException('MIDTRANS_SERVER_KEY belum dikonfigurasi');
        }

        $expected = hash(
            'sha512',
            ($payload['order_id'] ?? '') .
            ($payload['status_code'] ?? '') .
            ($payload['gross_amount'] ?? '') .
            $serverKey
        );

        if (! hash_equals($expected, $signatureKey)) {
            Log::warning('Midtrans signature mismatch', ['order_id' => $payload['order_id'] ?? null]);
            throw new \RuntimeException('Invalid Midtrans signature');
        }
    }

    public function applyNotificationToTransaction(Transaction $transaction, object $notif): void
    {
        $oldPaymentStatus = $transaction->payment_status;
        $paymentStatus = $this->mapPaymentStatus(
            $notif->transaction_status ?? '',
            $notif->fraud_status ?? null
        );

        $updateData = [
            'payment_status' => $paymentStatus,
            'midtrans_transaction_id' => $notif->transaction_id ?? $transaction->midtrans_transaction_id,
            'payment_method' => $notif->payment_type ?? $transaction->payment_method,
        ];

        if ($paymentStatus === 'paid' && ! $transaction->paid_at) {
            $updateData['paid_at'] = now();
        }

        if ($paymentStatus === 'paid' && $transaction->status === 'pending') {
            $updateData['status'] = 'processing';
        }

        if ($paymentStatus === 'expired' && $transaction->status === 'pending') {
            $updateData['status'] = 'expired';
            $this->restoreStock($transaction);
        }

        if ($paymentStatus === 'failed' && $transaction->status === 'pending') {
            $updateData['status'] = 'cancelled';
            $this->restoreStock($transaction);
        }

        $transaction->update($updateData);

        // Hanya kirim notifikasi jika status pembayaran berubah
        if ($oldPaymentStatus !== $paymentStatus) {
            $transaction->loadMissing('user');
            if ($paymentStatus === 'paid') {
                \App\Models\Notification::create([
                    'user_id' => $transaction->user_id,
                    'title' => 'Pembayaran Diterima 💳',
                    'message' => "Pembayaran untuk pesanan #{$transaction->invoice_number} telah berhasil kami terima. Pesanan Anda sedang diproses.",
                    'type' => 'info',
                    'link' => route('transactions.show', $transaction->id),
                    'is_read' => false,
                ]);

                \App\Models\Notification::sendToAdmins(
                    'Pembayaran Diterima 💳',
                    "Pembayaran pesanan #{$transaction->invoice_number} sebesar Rp " . number_format($transaction->grand_total, 0, ',', '.') . " telah berhasil diterima.",
                    'info',
                    route('admin.transactions.show', $transaction->id)
                );
            } elseif ($paymentStatus === 'expired') {
                \App\Models\Notification::create([
                    'user_id' => $transaction->user_id,
                    'title' => 'Pesanan Kadaluarsa ⏰',
                    'message' => "Batas waktu pembayaran pesanan #{$transaction->invoice_number} telah habis. Pesanan dibatalkan otomatis.",
                    'type' => 'info',
                    'link' => route('transactions.show', $transaction->id),
                    'is_read' => false,
                ]);
            } elseif ($paymentStatus === 'failed') {
                \App\Models\Notification::create([
                    'user_id' => $transaction->user_id,
                    'title' => 'Pembayaran Gagal ❌',
                    'message' => "Pembayaran untuk pesanan #{$transaction->invoice_number} gagal diproses.",
                    'type' => 'info',
                    'link' => route('transactions.show', $transaction->id),
                    'is_read' => false,
                ]);
            }
        }
    }

    private function mapPaymentStatus(string $transactionStatus, ?string $fraudStatus): string
    {
        return match ($transactionStatus) {
            'capture' => ($fraudStatus === 'accept' || $fraudStatus === null) ? 'paid' : 'pending',
            'settlement' => 'paid',
            'pending' => 'pending',
            'deny' => 'failed',
            'expire' => 'expired',
            'cancel' => 'failed',
            default => 'pending',
        };
    }

    private function restoreStock(Transaction $transaction): void
    {
        $transaction->loadMissing('details.product');

        foreach ($transaction->details as $detail) {
            if ($detail->product) {
                $detail->product->increaseStock($detail->quantity);
            }
        }
    }
}
