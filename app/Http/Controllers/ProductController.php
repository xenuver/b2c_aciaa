<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_active', 1);
        
        // ========== FITUR PENCARIAN ==========
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // Filter kategori
        if ($request->has('category') && $request->category) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Filter harga
        if ($request->has('min_price') && $request->min_price) {
            $query->where(function($q) use ($request) {
                $q->where('price', '>=', $request->min_price)
                  ->orWhere('discount_price', '>=', $request->min_price);
            });
        }
        
        if ($request->has('max_price') && $request->max_price) {
            $query->where(function($q) use ($request) {
                $q->where('price', '<=', $request->max_price)
                  ->orWhere('discount_price', '<=', $request->max_price);
            });
        }
        
        // Sorting
        $sort = $request->get('sort', 'terbaru');
        switch($sort) {
            case 'termurah':
                $query->orderByRaw('COALESCE(discount_price, price) ASC');
                break;
            case 'termahal':
                $query->orderByRaw('COALESCE(discount_price, price) DESC');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }
        
        // Produk promo di atas
        $promoProducts = Product::where('is_active', 1)
            ->where(function($q) {
                $q->where('is_promo', 1)->orWhereNotNull('discount_price');
            })
            ->limit(4)
            ->get();
            
        $products = $query->paginate(12);
        
        // Agar keyword search tetap terbawa saat pagination
        $products->appends(['search' => $request->search]);
        
        $categories = Category::where('is_active', 1)->withCount(['products' => function($q) {
            $q->where('is_active', 1);
        }])->get();
        
        $allProductsCount = Product::where('is_active', 1)->count();

        // ========== FITUR REKOMENDASI DINAMIS ==========
        $recommendations = collect();
        $recoSubtitle = 'Produk terbaru dari koleksi kami';

        if (auth()->check()) {
            // Ambil semua produk dari wishlist user
            $recommendations = Product::where('is_active', 1)
                ->whereHas('wishlists', function($q) {
                    $q->where('user_id', auth()->id());
                })
                ->limit(8)
                ->get();
            
            if ($recommendations->isNotEmpty()) {
                $recoSubtitle = 'Berdasarkan produk favorit yang Anda simpan';
            }
        }

        // Jika guest atau wishlist kosong, cari produk terfavorit (paling banyak dibeli: sold_count > 0)
        if ($recommendations->isEmpty()) {
            $recommendations = Product::where('is_active', 1)
                ->where('sold_count', '>', 0)
                ->orderBy('sold_count', 'desc')
                ->limit(8)
                ->get();
            
            if ($recommendations->isNotEmpty()) {
                $recoSubtitle = 'Produk paling populer dan disukai';
            } else {
                // Jika belum ada data (sold_count semuanya 0), tampilkan produk terbaru
                $recommendations = Product::where('is_active', 1)
                    ->orderBy('created_at', 'desc')
                    ->limit(8)
                    ->get();
                $recoSubtitle = 'Produk terbaru dari koleksi kami';
            }
        }
        
        return view('frontend.products.index', compact('products', 'categories', 'promoProducts', 'allProductsCount', 'recommendations', 'recoSubtitle'));
    }
    
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->where('is_active', 1)->firstOrFail();
        
        // Update view count
        $product->increment('views_count');
        
        // Rekomendasi produk terkait (kategori sama)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', 1)
            ->limit(4)
            ->get();
        
        // Testimoni
        $reviews = $product->ratings()->where('is_approved', 1)->with('user')->get();
        $averageRating = $reviews->avg('rating') ?? 0;
        
        return view('frontend.products.show', compact('product', 'relatedProducts', 'reviews', 'averageRating'));
    }
    
    // HAPUS method search() 
    // public function search(Request $request)
    // {
    //     $keyword = $request->get('q');
    //     $products = Product::where('is_active', 1)
    //         ->where('name', 'like', "%{$keyword}%")
    //         ->paginate(12);
    //         
    //     return view('frontend.products.index', compact('products'));
    // }
}