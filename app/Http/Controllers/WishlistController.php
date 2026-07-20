<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

class WishlistController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $wishlists = Wishlist::where('user_id', Auth::id())
                ->with('product')
                ->orderBy('created_at', 'desc')
                ->paginate(12);
        } else {
            $guestWishlist = session('guest_wishlist', []);
            $perPage = 12;
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $currentItems = array_slice($guestWishlist, ($currentPage - 1) * $perPage, $perPage);
            
            $products = Product::whereIn('id', $currentItems)->get()->keyBy('id');
            
            $wishlistItems = collect();
            foreach ($currentItems as $productId) {
                if (isset($products[$productId])) {
                    $wishlistItems->push((object)[
                        'id' => $productId,
                        'product_id' => $productId,
                        'product' => $products[$productId]
                    ]);
                }
            }
            
            $wishlists = new LengthAwarePaginator(
                $wishlistItems,
                count($guestWishlist),
                $perPage,
                $currentPage,
                ['path' => LengthAwarePaginator::resolveCurrentPath()]
            );
        }
        
        return view('frontend.wishlist.index', compact('wishlists'));
    }

    public function toggle(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        
        if (Auth::check()) {
            $wishlist = Wishlist::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->first();
            
            if ($wishlist) {
                // Hapus dari wishlist
                $wishlist->delete();
                $message = 'Produk dihapus dari wishlist';
                $status = 'removed';
            } else {
                // Tambah ke wishlist
                Wishlist::create([
                    'user_id' => Auth::id(),
                    'product_id' => $productId
                ]);
                $message = 'Produk ditambahkan ke wishlist';
                $status = 'added';
            }
        } else {
            $wishlist = session('guest_wishlist', []);
            if (in_array($productId, $wishlist)) {
                $wishlist = array_diff($wishlist, [$productId]);
                $message = 'Produk dihapus dari wishlist';
                $status = 'removed';
            } else {
                $wishlist[] = $productId;
                $message = 'Produk ditambahkan ke wishlist';
                $status = 'added';
            }
            session(['guest_wishlist' => array_values($wishlist)]);
        }

        // Return JSON untuk AJAX request
        if ($request->ajax() || $request->wantsJson()) {
            $count = Auth::check()
                ? Wishlist::where('user_id', Auth::id())->count()
                : count(session('guest_wishlist', []));
                
            return response()->json([
                'status' => $status,
                'message' => $message,
                'count' => $count
            ]);
        }
        
        return redirect()->back()->with($status === 'added' ? 'success' : 'info', $message);
    }

    public function remove(Request $request, $id)
    {
        if (Auth::check()) {
            $wishlist = Wishlist::where('user_id', Auth::id())
                ->findOrFail($id);
            
            $wishlist->delete();
            $count = Wishlist::where('user_id', Auth::id())->count();
        } else {
            // Guest: $id is product ID
            $wishlist = session('guest_wishlist', []);
            $wishlist = array_diff($wishlist, [$id]);
            session(['guest_wishlist' => array_values($wishlist)]);
            $count = count($wishlist);
        }

        // Return JSON untuk AJAX request
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => 'removed',
                'message' => 'Produk dihapus dari wishlist',
                'count' => $count
            ]);
        }
        
        return redirect()->route('wishlist.index')->with('success', 'Produk dihapus dari wishlist');
    }

    public function getCount()
    {
        if (!Auth::check()) {
            $count = count(session('guest_wishlist', []));
            return response()->json(['count' => $count]);
        }
        
        $count = Wishlist::where('user_id', Auth::id())->count();
        
        return response()->json(['count' => $count]);
    }

    /**
     * Toggle wishlist via AJAX
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxToggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);
        
        $productId = (int) $request->product_id;
        
        if (Auth::check()) {
            $wishlist = Wishlist::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->first();
            
            if ($wishlist) {
                // Hapus dari wishlist
                $wishlist->delete();
                $inWishlist = false;
                $message = 'Produk dihapus dari wishlist';
            } else {
                // Tambah ke wishlist
                Wishlist::create([
                    'user_id' => Auth::id(),
                    'product_id' => $productId
                ]);
                $inWishlist = true;
                $message = 'Produk ditambahkan ke wishlist';
            }
        } else {
            $wishlist = session('guest_wishlist', []);
            if (in_array($productId, $wishlist)) {
                $wishlist = array_diff($wishlist, [$productId]);
                $inWishlist = false;
                $message = 'Produk dihapus dari wishlist';
            } else {
                $wishlist[] = $productId;
                $inWishlist = true;
                $message = 'Produk ditambahkan ke wishlist';
            }
            session(['guest_wishlist' => array_values($wishlist)]);
        }

        return response()->json([
            'success' => true,
            'inWishlist' => $inWishlist,
            'message' => $message
        ]);
    }
}