<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        
        if (!$cart) {
            return view('frontend.cart.index', ['cartItems' => collect()]);
        }
        
        $cartItems = $cart->items()->with('product')->get();
        $total = $cartItems->sum(function($item) {
            return $item->quantity * $item->price;
        });
        
        return view('frontend.cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);
        $price = $product->discount_price ?? $product->price;
        
        // Get or create cart
        $cart = Cart::firstOrCreate([
            'user_id' => Auth::id()
        ]);
        
        // Check if product already in cart
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();
        
        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $price
            ]);
        }
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Produk ditambahkan ke keranjang',
                'cart_count' => $cart->items()->sum('quantity')
            ]);
        }
        
        return redirect()->route('cart.index')->with('success', 'Produk ditambahkan ke keranjang');
    }

    public function update(Request $request, $id)
    {
        $cartItem = CartItem::findOrFail($id);
        
        // Check ownership
        if ($cartItem->cart->user_id !== Auth::id()) {
            abort(403);
        }
        
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);
        
        $cartItem->quantity = $request->quantity;
        $cartItem->save();
        
        return redirect()->route('cart.index')->with('success', 'Keranjang diperbarui');
    }

    public function remove($id)
    {
        $cartItem = CartItem::findOrFail($id);
        
        if ($cartItem->cart->user_id !== Auth::id()) {
            abort(403);
        }
        
        $cartItem->delete();
        
        return redirect()->route('cart.index')->with('success', 'Produk dihapus dari keranjang');
    }

    /**
     * Get cart count for navbar badge
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCount()
    {
        if (!Auth::check()) {
            return response()->json(['count' => 0]);
        }
        
        $cart = Cart::where('user_id', Auth::id())->first();
        
        if (!$cart) {
            return response()->json(['count' => 0]);
        }
        
        $count = CartItem::where('cart_id', $cart->id)->sum('quantity');
        
        return response()->json(['count' => $count]);
    }

    /**
     * Update cart item quantity via AJAX
     * 
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CartItem $cartItem
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxUpdate(Request $request, CartItem $cartItem)
    {
        // Check ownership
        if ($cartItem->cart->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
        
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);
        
        $cartItem->quantity = $request->quantity;
        $cartItem->save();
        
        $cart = $cartItem->cart;
        $cartItems = $cart->items()->get();
        $cart_total = $cartItems->sum(function($item) {
            return $item->quantity * $item->price;
        });
        
        $cart_count = $cartItems->sum('quantity');
        $subtotal = $cartItem->quantity * $cartItem->price;
        
        return response()->json([
            'success' => true,
            'subtotal' => $subtotal,
            'cart_total' => $cart_total,
            'cart_count' => $cart_count,
            'message' => 'Keranjang diperbarui'
        ]);
    }

    /**
     * Remove cart item via AJAX
     * 
     * @param \App\Models\CartItem $cartItem
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxRemove(CartItem $cartItem)
    {
        // Check ownership
        if ($cartItem->cart->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
        
        $cart = $cartItem->cart;
        $cartItem->delete();
        
        $cartItems = $cart->items()->get();
        $cart_total = $cartItems->sum(function($item) {
            return $item->quantity * $item->price;
        });
        
        $cart_count = $cartItems->sum('quantity');
        
        return response()->json([
            'success' => true,
            'cart_total' => $cart_total,
            'cart_count' => $cart_count,
            'message' => 'Produk dihapus dari keranjang'
        ]);
    }
}