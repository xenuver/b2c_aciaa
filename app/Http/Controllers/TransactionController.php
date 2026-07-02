<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Services\MidtransService;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index(MidtransService $midtransService)
    {
        // Temukan transaksi user yang berstatus pending dan belum dibayar untuk disinkronkan
        $pendingTransactions = Transaction::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->whereIn('payment_status', ['unpaid', 'pending'])
            ->get();
            
        foreach ($pendingTransactions as $transaction) {
            try {
                $midtransService->syncTransactionStatus($transaction);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::warning('Error syncing transaction status in list: ' . $e->getMessage());
            }
        }

        $transactions = Transaction::with('details.product')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('frontend.transactions.index', compact('transactions'));
    }

    public function show($id, MidtransService $midtransService)
    {
        $transaction = Transaction::with('details.product')
            ->where('user_id', Auth::id())
            ->findOrFail($id);
        
        // Sync status with Midtrans if transaction is pending and not paid
        if ($transaction->status === 'pending' && in_array($transaction->payment_status, ['unpaid', 'pending'])) {
            $transaction = $midtransService->syncTransactionStatus($transaction);
            
            // If still pending/unpaid and snap_token is missing, generate it
            if ($transaction->status === 'pending' && !$transaction->isPaymentExpired()) {
                if (empty($transaction->snap_token)) {
                    try {
                        $snapResponse = $midtransService->createSnapTransaction($transaction);
                        $transaction->update([
                            'snap_token' => $snapResponse->token,
                            'snap_url' => $snapResponse->redirect_url,
                            'payment_expired_at' => now()->addHours(24),
                        ]);
                        $transaction = $transaction->fresh();
                    } catch (\Exception $e) {
                        \Illuminate\Support\Facades\Log::error('Regenerate snap token error: ' . $e->getMessage());
                    }
                }
            }
        }
        
        // Calculate remaining seconds to expiry
        $remainingSeconds = 0;
        if ($transaction->status === 'pending' && !$transaction->isPaymentExpired() && $transaction->payment_expired_at) {
            $remainingSeconds = now()->diffInSeconds($transaction->payment_expired_at, false);
            if ($remainingSeconds < 0) {
                $remainingSeconds = 0;
            }
        }
        
        return view('frontend.transactions.show', compact('transaction', 'remainingSeconds'));
    }
}