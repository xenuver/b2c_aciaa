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
        
        $isSearching = $request->filled('search') || $request->filled('category') || $request->filled('min_price') || $request->filled('max_price');
        
        // Produk promo di atas (hanya tampil jika tidak sedang mencari/filter)
        $promoProducts = collect();
        if (!$isSearching) {
            $promoProducts = Product::where('is_active', 1)
                ->where(function($q) {
                    $q->where('is_promo', 1)->orWhereNotNull('discount_price');
                })
                ->limit(4)
                ->get();
        }
            
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

        if (!$isSearching) {
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
        }
        
        return view('frontend.products.index', compact('products', 'categories', 'promoProducts', 'allProductsCount', 'recommendations', 'recoSubtitle'));
    }
    
    public function show(Request $request, $slug)
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
        $reviewsQuery = $product->ratings()->where('is_approved', 1)->with('user')->latest();
        $averageRating = $product->ratings()->where('is_approved', 1)->avg('rating') ?? 0;
        $totalReviews = $product->ratings()->where('is_approved', 1)->count();
        
        if ($request->ajax() && $request->has('load_reviews')) {
            $reviews = $reviewsQuery->paginate(5);
            $html = '';
            foreach($reviews as $review) {
                $html .= view('components.review-card', compact('review'))->render();
            }
            return response()->json([
                'html' => $html,
                'hasMore' => $reviews->hasMorePages()
            ]);
        }
        
        $reviews = $reviewsQuery->paginate(5);
        
        return view('frontend.products.show', compact('product', 'relatedProducts', 'reviews', 'averageRating', 'totalReviews'));
    }
    
    /**
     * AJAX endpoint untuk halaman produk — mengembalikan JSON berisi HTML rendered
     * product card, total produk, dan info pagination.
     *
     * GET /products/ajax?search=&category=&min_price=&max_price=&sort=&page=
     *
     * Response: { html: '...', total: N, hasPages: bool }
     */
    public function ajaxIndex(Request $request)
    {
        $query = Product::with(['category'])
            ->withAvg(['ratings' => function ($q) {
                $q->where('is_approved', 1);
            }], 'rating')
            ->where('is_active', 1);

        // ===== Filter: search =====
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // ===== Filter: category (slug atau id) =====
        if ($request->filled('category')) {
            $categoryParam = $request->category;
            $query->whereHas('category', function ($q) use ($categoryParam) {
                if (is_numeric($categoryParam)) {
                    $q->where('id', $categoryParam);
                } else {
                    $q->where('slug', $categoryParam);
                }
            });
        }

        // ===== Filter: min_price =====
        if ($request->filled('min_price')) {
            $minPrice = (int) $request->min_price;
            $query->where(function ($q) use ($minPrice) {
                $q->where('price', '>=', $minPrice)
                  ->orWhere('discount_price', '>=', $minPrice);
            });
        }

        // ===== Filter: max_price =====
        if ($request->filled('max_price')) {
            $maxPrice = (int) $request->max_price;
            $query->where(function ($q) use ($maxPrice) {
                $q->where('price', '<=', $maxPrice)
                  ->orWhere('discount_price', '<=', $maxPrice);
            });
        }

        // ===== Sorting =====
        // Mendukung nilai baru (newest/price_low/price_high/popular) dan nilai lama (terbaru/termurah/termahal)
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'price_low':
            case 'termurah':
                $query->orderByRaw('COALESCE(discount_price, price) ASC');
                break;
            case 'price_high':
            case 'termahal':
                $query->orderByRaw('COALESCE(discount_price, price) DESC');
                break;
            case 'popular':
                $query->orderBy('sold_count', 'desc');
                break;
            case 'newest':
            case 'terbaru':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $products = $query->paginate(12)->withQueryString();

        // Render setiap product card via Blade component
        $html = '';
        foreach ($products as $product) {
            $html .= view('components.product-card', ['product' => $product])->render();
        }

        return response()->json([
            'html'       => $html,
            'total'      => $products->total(),
            'hasPages'   => $products->hasPages(),
            'pagination' => $products->hasPages() ? (string) $products->links() : '',
        ]);
    }

    /**
     * Live search endpoint untuk navbar — mengembalikan JSON maks. 8 produk aktif
     * yang cocok dengan nama produk ATAU nama kategori.
     *
     * GET /api/search/live?q=...
     */
    public function liveSearch(Request $request)
    {
        $q = trim($request->get('q', ''));

        // Jika query kosong atau kurang dari 2 karakter, kembalikan array kosong
        if (mb_strlen($q) < 2) {
            return response()->json(['products' => []]);
        }

        $products = Product::with('category')
            ->where('is_active', 1)
            ->where(function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                      ->orWhereHas('category', function ($catQuery) use ($q) {
                          $catQuery->where('name', 'like', "%{$q}%");
                      });
            })
            ->select(['id', 'name', 'slug', 'price', 'discount_price', 'image', 'category_id'])
            ->limit(8)
            ->get()
            ->map(function ($product) {
                return [
                    'id'             => $product->id,
                    'name'           => $product->name,
                    'slug'           => $product->slug,
                    'price'          => $product->price,
                    'discount_price' => $product->discount_price,
                    'image'          => $product->image
                        ? asset('storage/' . $product->image)
                        : asset('images/no-image.png'),
                    'category_name'  => $product->category ? $product->category->name : null,
                    'url'            => route('products.show', $product->slug),
                ];
            });

        return response()->json(['products' => $products]);
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