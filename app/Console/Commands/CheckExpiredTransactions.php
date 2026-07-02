<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckExpiredTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-expired-transactions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks for transactions that have passed their payment deadline and syncs their status with Midtrans or cancels them.';

    /**
     * Execute the console command.
     */
    public function handle(\App\Services\MidtransService $midtransService)
    {
        $this->info('Starting check for expired transactions...');

        $expiredTransactions = \App\Models\Transaction::where('status', 'pending')
            ->whereIn('payment_status', ['unpaid', 'pending'])
            ->where('payment_expired_at', '<=', now())
            ->get();

        $count = $expiredTransactions->count();
        $this->info("Found {$count} potentially expired transactions.");

        foreach ($expiredTransactions as $transaction) {
            $this->info("Syncing transaction #{$transaction->invoice_number} (ID: {$transaction->id})...");
            try {
                $syncTx = $midtransService->syncTransactionStatus($transaction);
                $this->info("Transaction #{$transaction->invoice_number} status updated to: status={$syncTx->status}, payment_status={$syncTx->payment_status}");
            } catch (\Exception $e) {
                $this->error("Failed to sync transaction #{$transaction->invoice_number}: " . $e->getMessage());
            }
        }

        $this->info('Expired transactions check completed.');
    }
}
