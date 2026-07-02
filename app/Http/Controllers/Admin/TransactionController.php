<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Support\ShippingTracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with('user');
        
        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        // Filter berdasarkan tanggal
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $transactions = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Data untuk filter
        $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
        
        return view('admin.transactions.index', compact('transactions', 'statuses'));
    }
    
    public function show($id)
    {
        $transaction = Transaction::with(['user', 'details.product'])->findOrFail($id);
        return view('admin.transactions.show', compact('transaction'));
    }
    
    public function updateStatus(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);
        
        $oldStatus = $transaction->status;
        $newStatus = $request->status;
        
        // Update timestamp berdasarkan status
        $updateData = ['status' => $newStatus];
        
        if ($newStatus == 'shipped' && !$transaction->shipped_at) {
            $updateData['shipped_at'] = now();
        }
        
        if ($newStatus == 'delivered' && !$transaction->delivered_at) {
            $updateData['delivered_at'] = now();
        }
        
        if ($newStatus == 'cancelled' && $transaction->status != 'cancelled') {
            // Kembalikan stok jika dibatalkan
            foreach ($transaction->details as $detail) {
                $detail->product->increaseStock($detail->quantity);
            }
        }
        
        $transaction->update($updateData);

        if ($oldStatus !== $newStatus) {
            if ($newStatus === 'processing') {
                \App\Models\Notification::create([
                    'user_id' => $transaction->user_id,
                    'title' => 'Pesanan Diproses 📦',
                    'message' => "Pesanan Anda #{$transaction->invoice_number} sedang diproses dan dikemas.",
                    'type' => 'info',
                    'link' => route('transactions.show', $transaction->id),
                    'is_read' => false,
                ]);
            } elseif ($newStatus === 'shipped' && empty($transaction->tracking_number)) {
                \App\Models\Notification::create([
                    'user_id' => $transaction->user_id,
                    'title' => 'Pesanan Dikirim 🚚',
                    'message' => "Pesanan Anda #{$transaction->invoice_number} telah dikirim.",
                    'type' => 'shipping',
                    'link' => route('transactions.show', $transaction->id),
                    'is_read' => false,
                ]);
            } elseif ($newStatus === 'delivered') {
                \App\Models\Notification::create([
                    'user_id' => $transaction->user_id,
                    'title' => 'Pesanan Telah Tiba 🏡',
                    'message' => "Pesanan Anda #{$transaction->invoice_number} telah sampai di tujuan. Silakan konfirmasi penerimaan dan berikan ulasan produk.",
                    'type' => 'shipping',
                    'link' => route('transactions.show', $transaction->id),
                    'is_read' => false,
                ]);
            } elseif ($newStatus === 'cancelled') {
                \App\Models\Notification::create([
                    'user_id' => $transaction->user_id,
                    'title' => 'Pesanan Dibatalkan 🚫',
                    'message' => "Pesanan Anda #{$transaction->invoice_number} telah dibatalkan oleh pihak toko.",
                    'type' => 'info',
                    'link' => route('transactions.show', $transaction->id),
                    'is_read' => false,
                ]);
            }
        }
        
        return redirect()->route('admin.transactions.index')
            ->with('success', "Status pesanan berhasil diubah dari {$oldStatus} menjadi {$newStatus}");
    }
    
    public function updatePaymentStatus(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        
        $request->validate([
            'payment_status' => 'required|in:unpaid,pending,paid,failed,expired'
        ]);
        
        $oldStatus = $transaction->payment_status;
        $newStatus = $request->payment_status;
        
        $updateData = ['payment_status' => $newStatus];
        
        if ($newStatus == 'paid' && !$transaction->paid_at) {
            $updateData['paid_at'] = now();
        }
        
        $transaction->update($updateData);

        if ($oldStatus !== $newStatus) {
            $transaction->loadMissing('user');
            if ($newStatus === 'paid') {
                \App\Models\Notification::create([
                    'user_id' => $transaction->user_id,
                    'title' => 'Pembayaran Diterima 💳',
                    'message' => "Pembayaran untuk pesanan #{$transaction->invoice_number} telah berhasil kami terima. Pesanan Anda sedang diproses.",
                    'type' => 'info',
                    'link' => route('transactions.show', $transaction->id),
                    'is_read' => false,
                ]);

                \App\Models\Notification::sendToAdmins(
                    'Pembayaran Diperbarui (Admin) 💳',
                    "Status pembayaran pesanan #{$transaction->invoice_number} telah diubah menjadi LUNAS oleh admin.",
                    'info',
                    route('admin.transactions.show', $transaction->id)
                );
            } elseif ($newStatus === 'failed') {
                \App\Models\Notification::create([
                    'user_id' => $transaction->user_id,
                    'title' => 'Pembayaran Gagal ❌',
                    'message' => "Pembayaran untuk pesanan #{$transaction->invoice_number} gagal diproses.",
                    'type' => 'info',
                    'link' => route('transactions.show', $transaction->id),
                    'is_read' => false,
                ]);
            } elseif ($newStatus === 'expired') {
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
        
        return redirect()->route('admin.transactions.index')
            ->with('success', "Status pembayaran berhasil diubah dari {$oldStatus} menjadi {$newStatus}");
    }

    public function updateTracking(Request $request, $id)
    {
        $transaction = Transaction::with('user')->findOrFail($id);

        $request->validate([
            'tracking_number' => 'required|string|max:100',
        ]);

        if ($transaction->payment_status !== 'paid') {
            return redirect()->route('admin.transactions.show', $id)
                ->with('error', 'Resi hanya dapat diinput setelah pembayaran lunas.');
        }

        $trackingNumber = trim($request->tracking_number);
        $wasEmpty = empty($transaction->tracking_number);
        $notificationSent = false;
        $notificationWarning = null;

        $transaction->update([
            'tracking_number' => $trackingNumber,
            'tracking_url' => ShippingTracking::buildUrl($transaction->shipping_courier, $trackingNumber),
            'status' => 'shipped',
            'shipped_at' => $transaction->shipped_at ?? now(),
        ]);

        $transaction->refresh();

        if ($wasEmpty) {
            try {
                \App\Models\Notification::create([
                    'user_id' => $transaction->user_id,
                    'title' => 'Pesanan Dikirim 🚚',
                    'message' => "Pesanan Anda #{$transaction->id} telah dikirim menggunakan kurir " . strtoupper($transaction->shipping_courier) . " dengan nomor resi: {$trackingNumber}.",
                    'type' => 'shipping',
                    'link' => route('transactions.show', $transaction->id),
                    'is_read' => false,
                ]);
                $notificationSent = true;
            } catch (\Exception $e) {
                Log::error('Gagal membuat notifikasi web resi: ' . $e->getMessage(), [
                    'transaction_id' => $transaction->id,
                ]);
                $notificationWarning = 'Resi tersimpan, tetapi gagal membuat notifikasi web.';
            }
        }

        $message = $wasEmpty
            ? ($notificationSent ? 'Resi disimpan, status dikirim, dan notifikasi web telah dikirim ke pelanggan.' : 'Resi disimpan dan status dikirim.')
            : 'Nomor resi berhasil diperbarui.';

        return redirect()->route('admin.transactions.show', $id)
            ->with($notificationWarning ? 'warning' : 'success', $notificationWarning ?? $message);
    }
}