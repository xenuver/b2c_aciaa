<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Banner;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function landing()
    {
        // Kategori utama (aktif) dengan hitungan produk aktif
        $categories = Category::where('is_active', 1)
            ->withCount(['products' => function($q) {
                $q->where('is_active', 1);
            }])
            ->orderBy('order')
            ->get();

        // Banner aktif
        $banners = Banner::where('is_active', 1)
            ->where(function($q) {
                $q->whereNull('start_date')->orWhere('start_date', '<=', now());
            })
            ->where(function($q) {
                $q->whereNull('end_date')->orWhere('end_date', '>=', now());
            })
            ->orderBy('order')
            ->get();

        // Produk unggulan (berdasarkan sold_count, max 4)
        $featuredProducts = Product::where('is_active', 1)
            ->orderBy('sold_count', 'desc')
            ->limit(4)
            ->get();

        return view('frontend.landing', compact('categories', 'banners', 'featuredProducts'));
    }

    public function index()
    {
        // Banner aktif
        $banners = Banner::where('is_active', 1)
            ->where(function($q) {
                $q->whereNull('start_date')->orWhere('start_date', '<=', now());
            })
            ->where(function($q) {
                $q->whereNull('end_date')->orWhere('end_date', '>=', now());
            })
            ->orderBy('order')
            ->get();

        // Kategori utama (aktif) dengan hitungan produk aktif
        $categories = Category::where('is_active', 1)
            ->withCount(['products' => function($q) {
                $q->where('is_active', 1);
            }])
            ->orderBy('order')
            ->get();

        // Produk promo (yang memiliki discount_price)
        $promoProducts = Product::where('is_active', 1)
            ->where('is_promo', 1)
            ->orWhereNotNull('discount_price')
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        // Produk terbaru (max 8)
        $newProducts = Product::where('is_active', 1)
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        // ========== REKOMENDASI BERDASARKAN WISHLIST ==========
        $recommendations = collect();
        $recommendationTitle = 'Produk Populer';
        $recommendationSubtitle = 'Trending Now';

        if (Auth::check()) {
            // Ambil product_id dan category_id dari wishlist user
            $wishlistProductIds = Wishlist::where('user_id', Auth::id())
                ->pluck('product_id')
                ->toArray();

            if (!empty($wishlistProductIds)) {
                // Ambil category_id dari produk yang di-wishlist
                $wishlistCategoryIds = Product::whereIn('id', $wishlistProductIds)
                    ->where('is_active', 1)
                    ->pluck('category_id')
                    ->unique()
                    ->toArray();

                if (!empty($wishlistCategoryIds)) {
                    // Ambil produk dari kategori yang sama, exclude yang sudah di wishlist
                    $recommendations = Product::where('is_active', 1)
                        ->whereIn('category_id', $wishlistCategoryIds)
                        ->whereNotIn('id', $wishlistProductIds)
                        ->orderBy('sold_count', 'desc')
                        ->limit(8)
                        ->get();

                    $recommendationTitle = 'Rekomendasi Untuk Anda';
                    $recommendationSubtitle = 'Personalized';
                }
            }
        }

        // Fallback: jika rekomendasi kosong, tampilkan produk populer
        if ($recommendations->isEmpty()) {
            $recommendations = Product::where('is_active', 1)
                ->orderBy('sold_count', 'desc')
                ->limit(8)
                ->get();
            $recommendationTitle = 'Produk Populer';
            $recommendationSubtitle = 'Trending Now';
        }

        return view('frontend.home', compact(
            'banners', 'categories', 'promoProducts', 'newProducts',
            'recommendations', 'recommendationTitle', 'recommendationSubtitle'
        ));
    }

    public function vouchers()
    {
        $vouchers = \App\Models\Voucher::where('is_active', 1)
            ->where('expiry_date', '>=', date('Y-m-d'))
            ->orderBy('expiry_date', 'asc')
            ->get();

        $claimedVoucherCodes = [];
        if (\Illuminate\Support\Facades\Auth::check()) {
            $claimedVoucherCodes = \App\Models\UserVoucher::where('user_id', \Illuminate\Support\Facades\Auth::id())
                ->pluck('voucher_code')
                ->toArray();
        }

        return view('frontend.vouchers.index', compact('vouchers', 'claimedVoucherCodes'));
    }

    public function claimVoucher(Request $request, $id)
    {
        $voucher = \App\Models\Voucher::where('is_active', 1)
            ->where('expiry_date', '>=', date('Y-m-d'))
            ->findOrFail($id);

        $user = \Illuminate\Support\Facades\Auth::user();

        $alreadyClaimed = \App\Models\UserVoucher::where('user_id', $user->id)
            ->where('voucher_code', $voucher->code)
            ->exists();

        if ($alreadyClaimed) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Voucher ini sudah diklaim sebelumnya.'], 422);
            }
            return back()->with('error', 'Voucher ini sudah diklaim sebelumnya.');
        }

        if ($voucher->max_usage !== null && $voucher->used_count >= $voucher->max_usage) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Maaf, kuota voucher ini sudah habis.'], 422);
            }
            return back()->with('error', 'Maaf, kuota voucher ini sudah habis.');
        }

        // Validasi voucher pengguna aktif
        if ($voucher->user_type === 'active_user') {
            $completedOrders = $user->getCompletedOrdersCount();
            if ($completedOrders < $voucher->min_completed_orders) {
                $message = 'Voucher ini khusus untuk pengguna aktif. Anda membutuhkan minimal ' . $voucher->min_completed_orders . ' pesanan selesai (Anda memiliki ' . $completedOrders . ').';
                if ($request->expectsJson()) {
                    return response()->json(['success' => false, 'message' => $message], 422);
                }
                return back()->with('error', $message);
            }
        }

        \App\Models\UserVoucher::create([
            'user_id' => $user->id,
            'voucher_id' => $id,
            'voucher_code' => $voucher->code,
            'is_used' => false
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Voucher berhasil diklaim! Silakan gunakan saat checkout.',
                'voucher' => [
                    'id' => $voucher->id,
                    'code' => $voucher->code,
                    'name' => $voucher->name,
                ]
            ]);
        }

        return back()->with('success', 'Voucher berhasil diklaim! Silakan gunakan saat checkout.');
    }
}