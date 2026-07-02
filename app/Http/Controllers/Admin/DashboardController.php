<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Category;
use App\Models\Retur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Produk dengan stok menipis (kurang dari atau sama dengan 15)
        $low_stock_products_list = Product::where('stock', '<=', 15)
            ->where('stock', '>', 0)
            ->orderBy('stock', 'asc')
            ->limit(10)
            ->get();

        // Total produk
        $total_products = Product::count();
        
        // Total kategori
        $total_categories = Category::count();
        
        // Total customer (user dengan role customer)
        $total_users = User::where('role', 'customer')->count();
        
        // Total transaksi (semua status)
        $total_transactions = Transaction::count();
        
        // Total pendapatan dari transaksi yang statusnya 'delivered' (sudah selesai)
        $total_revenue = Transaction::where('status', 'delivered')->sum('grand_total');
        
        // Total pendapatan dari transaksi yang statusnya 'paid' (sudah bayar)
        $total_revenue_paid = Transaction::where('payment_status', 'paid')->sum('grand_total');
        
        // Transaksi pending
        $pending_transactions = Transaction::where('status', 'pending')->count();
        
        // Transaksi processing
        $processing_transactions = Transaction::where('status', 'processing')->count();
        
        // Transaksi shipped
        $shipped_transactions = Transaction::where('status', 'shipped')->count();
        
        // Transaksi delivered
        $delivered_transactions = Transaction::where('status', 'delivered')->count();
        
        // Transaksi cancelled
        $cancelled_transactions = Transaction::where('status', 'cancelled')->count();
        
        // Total retur pending
        $pending_returs = Retur::where('status', 'pending')->count();
        
        // Produk stok menipis (kurang dari 10)
        $low_stock_products = Product::where('stock', '<', 10)->where('stock', '>', 0)->count();
        
        // Produk stok habis
        $out_of_stock_products = Product::where('stock', 0)->count();
        
        // 5 transaksi terbaru
        $recent_transactions = Transaction::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // 5 produk terbaru
        $recent_products = Product::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // 5 customer teraktif (berdasarkan total belanja)
        $top_customers = User::where('role', 'customer')
            ->withSum('transactions', 'grand_total')
            ->orderBy('transactions_sum_grand_total', 'desc')
            ->limit(5)
            ->get();
        
        // Pendapatan per bulan (untuk chart)
        $monthly_revenue = Transaction::where('status', 'delivered')
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(grand_total) as total')
            )
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->limit(6)
            ->get();

        // Produk terlaris (untuk grafik batang)
        $top_sold_products = DB::table('transaction_details')
            ->join('products', 'transaction_details.product_id', '=', 'products.id')
            ->join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->whereIn('transactions.status', ['delivered', 'shipped', 'processing'])
            ->select(
                'products.name as product_name',
                DB::raw('SUM(transaction_details.quantity) as total_sold')
            )
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_sold', 'desc')
            ->limit(10)
            ->get();
        
        return view('admin.dashboard', compact(
            'total_products',
            'total_categories',
            'total_users',
            'total_transactions',
            'total_revenue',
            'total_revenue_paid',
            'pending_transactions',
            'processing_transactions',
            'shipped_transactions',
            'delivered_transactions',
            'cancelled_transactions',
            'pending_returs',
            'low_stock_products',
            'out_of_stock_products',
            'recent_transactions',
            'recent_products',
            'top_customers',
            'monthly_revenue',
            'low_stock_products_list',
            'top_sold_products'
        ));
    }
}