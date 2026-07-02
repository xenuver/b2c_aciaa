<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::where('user_id', Auth::id())
            ->with('product')
            ->orderBy('created_at', 'desc')
            ->paginate(12);
        
        return view('frontend.wishlist.index', compact('wishlists'));
    }

    public function toggle(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        
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

        // Return JSON untuk AJAX request
        if ($request->ajax() || $request->wantsJson()) {
            $count = Wishlist::where('user_id', Auth::id())->count();
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
        $wishlist = Wishlist::where('user_id', Auth::id())
            ->findOrFail($id);
        
        $wishlist->delete();

        // Return JSON untuk AJAX request
        if ($request->ajax() || $request->wantsJson()) {
            $count = Wishlist::where('user_id', Auth::id())->count();
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
        if (!auth()->check()) {
            return response()->json(['count' => 0]);
        }
        
        $count = Wishlist::where('user_id', auth()->id())->count();
        
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
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);
        
        $productId = $request->product_id;
        
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

        return response()->json([
            'success' => true,
            'inWishlist' => $inWishlist,
            'message' => $message
        ]);
    }
}