<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Default: bulan ini
        $startDate = $request->start_date ?? date('Y-m-01');
        $endDate = $request->end_date ?? date('Y-m-t');
        
        // Data untuk chart
        $salesData = $this->getSalesData($startDate, $endDate);
        $topProducts = $this->getTopProducts($startDate, $endDate);
        $topCustomers = $this->getTopCustomers($startDate, $endDate);
        
        // Ringkasan
        $summary = $this->getSummary($startDate, $endDate);
        
        return view('admin.reports.index', compact(
            'salesData', 'topProducts', 'topCustomers', 'summary', 'startDate', 'endDate'
        ));
    }
    
    private function getSalesData($startDate, $endDate)
    {
        $data = Transaction::whereBetween('created_at', [$startDate, $endDate . ' 23:59:59'])
            ->where('status', 'delivered')
            ->selectRaw('DATE(created_at) as date, COUNT(*) as orders, SUM(grand_total) as revenue')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        return [
            'labels' => $data->pluck('date')->map(function($date) {
                return date('d/m', strtotime($date));
            }),
            'orders' => $data->pluck('orders'),
            'revenue' => $data->pluck('revenue')
        ];
    }
    
    private function getTopProducts($startDate, $endDate)
    {
        return DB::table('transaction_details')
            ->join('products', 'transaction_details.product_id', '=', 'products.id')
            ->join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->whereBetween('transactions.created_at', [$startDate, $endDate . ' 23:59:59'])
            ->where('transactions.status', 'delivered')
            ->select(
                'products.id',
                'products.name',
                'products.image',
                DB::raw('SUM(transaction_details.quantity) as total_sold'),
                DB::raw('SUM(transaction_details.subtotal) as total_revenue')
            )
            ->groupBy('products.id', 'products.name', 'products.image')
            ->orderByDesc('total_sold')
            ->limit(10)
            ->get();
    }
    
    private function getTopCustomers($startDate, $endDate)
    {
        return Transaction::whereBetween('created_at', [$startDate, $endDate . ' 23:59:59'])
            ->where('status', 'delivered')
            ->with('user')
            ->select(
                'user_id',
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(grand_total) as total_spent')
            )
            ->groupBy('user_id')
            ->orderByDesc('total_spent')
            ->limit(10)
            ->get();
    }
    
    private function getSummary($startDate, $endDate)
    {
        $transactions = Transaction::whereBetween('created_at', [$startDate, $endDate . ' 23:59:59'])
            ->where('status', 'delivered');
        
        $allTransactions = Transaction::whereBetween('created_at', [$startDate, $endDate . ' 23:59:59']);
        
        return [
            'total_orders' => $transactions->count(),
            'total_revenue' => $transactions->sum('grand_total'),
            'average_order' => $transactions->avg('grand_total') ?? 0,
            'total_customers' => $transactions->distinct('user_id')->count('user_id'),
            'pending_orders' => $allTransactions->where('status', 'pending')->count(),
            'processing_orders' => $allTransactions->where('status', 'processing')->count(),
            'shipped_orders' => $allTransactions->where('status', 'shipped')->count(),
            'cancelled_orders' => $allTransactions->where('status', 'cancelled')->count(),
        ];
    }
    
    public function export(Request $request)
    {
        $startDate = $request->start_date ?? date('Y-m-01');
        $endDate = $request->end_date ?? date('Y-m-t');
        
        $transactions = Transaction::whereBetween('created_at', [$startDate, $endDate . ' 23:59:59'])
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();
        
        $filename = "laporan_penjualan_" . date('Ymd_His') . ".csv";
        
        $callback = function() use ($transactions) {
            $file = fopen('php://output', 'w');
            
            // Header CSV (gunakan titik koma agar kompatibel dengan Excel Indonesia)
            fputcsv($file, [
                'Invoice', 'Tanggal', 'Customer', 'Total', 'Status Pesanan', 'Status Pembayaran'
            ], ';');
            
            foreach ($transactions as $transaction) {
                fputcsv($file, [
                    $transaction->invoice_number,
                    $transaction->created_at->format('d/m/Y H:i'),
                    $transaction->user->name ?? '-',
                    number_format($transaction->grand_total, 0, ',', '.'),
                    $transaction->status,
                    $transaction->payment_status
                ], ';');
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }
}