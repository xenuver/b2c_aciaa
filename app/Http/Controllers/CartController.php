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
        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->first();
            
            if (!$cart) {
                return view('frontend.cart.index', ['cartItems' => collect(), 'total' => 0]);
            }
            
            $cartItems = $cart->items()->with('product')->get();
            $total = $cartItems->sum(function($item) {
                return $item->quantity * $item->price;
            });
        } else {
            // Guest: Get from session
            $sessionCart = session('guest_cart', []);
            $cartItems = $this->buildGuestCartItems($sessionCart);
            $total = $cartItems->sum(function($item) {
                return $item->quantity * $item->price;
            });
        }
        
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
        
        if (Auth::check()) {
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
            $cartCount = $cart->items()->sum('quantity');
        } else {
            // Guest: Save to session
            $cart = session('guest_cart', []);
            $key = 'p_' . $product->id;
            if (isset($cart[$key])) {
                $cart[$key]['quantity'] += $request->quantity;
            } else {
                $cart[$key] = [
                    'product_id' => $product->id,
                    'quantity' => $request->quantity,
                    'price' => $price
                ];
            }
            session(['guest_cart' => $cart]);
            $cartCount = collect($cart)->sum('quantity');
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Produk ditambahkan ke keranjang',
                'cart_count' => $cartCount
            ]);
        }
        
        return redirect()->route('cart.index')->with('success', 'Produk ditambahkan ke keranjang');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        if (Auth::check()) {
            $cartItem = CartItem::findOrFail($id);
            
            // Check ownership
            if ($cartItem->cart->user_id !== Auth::id()) {
                abort(403);
            }
            
            $cartItem->quantity = $request->quantity;
            $cartItem->save();
        } else {
            // Guest: update session by product ID
            $cart = session('guest_cart', []);
            $key = 'p_' . $id;
            if (isset($cart[$key])) {
                $cart[$key]['quantity'] = $request->quantity;
                session(['guest_cart' => $cart]);
            }
        }
        
        return redirect()->route('cart.index')->with('success', 'Keranjang diperbarui');
    }

    public function remove($id)
    {
        if (Auth::check()) {
            $cartItem = CartItem::findOrFail($id);
            
            if ($cartItem->cart->user_id !== Auth::id()) {
                abort(403);
            }
            
            $cartItem->delete();
        } else {
            // Guest: remove from session by product ID
            $cart = session('guest_cart', []);
            $key = 'p_' . $id;
            if (isset($cart[$key])) {
                unset($cart[$key]);
                session(['guest_cart' => $cart]);
            }
        }
        
        return redirect()->route('cart.index')->with('success', 'Produk dihapus dari keranjang');
    }

    /**
     * Get cart count for navbar badge
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCount()
    {
        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->first();
            
            if (!$cart) {
                return response()->json(['count' => 0]);
            }
            
            $count = CartItem::where('cart_id', $cart->id)->sum('quantity');
        } else {
            $cart = session('guest_cart', []);
            $count = collect($cart)->sum('quantity');
        }
        
        return response()->json(['count' => $count]);
    }

    /**
     * Update cart item quantity via AJAX
     * 
     * @param \Illuminate\Http\Request $request
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxUpdate(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        if (Auth::check()) {
            $cartItem = CartItem::findOrFail($id);
            
            // Check ownership
            if ($cartItem->cart->user_id !== Auth::id()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }
            
            $cartItem->quantity = $request->quantity;
            $cartItem->save();
            
            $cart = $cartItem->cart;
            $cartItems = $cart->items()->get();
            $cart_total = $cartItems->sum(function($item) {
                return $item->quantity * $item->price;
            });
            
            $cart_count = $cartItems->sum('quantity');
            $subtotal = $cartItem->quantity * $cartItem->price;
        } else {
            // Guest: update session where $id is the product ID
            $cart = session('guest_cart', []);
            $key = 'p_' . $id;
            
            if (!isset($cart[$key])) {
                return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan'], 404);
            }
            
            $cart[$key]['quantity'] = $request->quantity;
            session(['guest_cart' => $cart]);
            
            $cartItems = $this->buildGuestCartItems($cart);
            $cart_total = $cartItems->sum(function($item) {
                return $item->quantity * $item->price;
            });
            
            $cart_count = $cartItems->sum('quantity');
            $subtotal = $cart[$key]['quantity'] * $cart[$key]['price'];
        }
        
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
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxRemove($id)
    {
        if (Auth::check()) {
            $cartItem = CartItem::findOrFail($id);
            
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
        } else {
            // Guest: remove from session where $id is the product ID
            $cart = session('guest_cart', []);
            $key = 'p_' . $id;
            
            if (isset($cart[$key])) {
                unset($cart[$key]);
                session(['guest_cart' => $cart]);
            }
            
            $cartItems = $this->buildGuestCartItems($cart);
            $cart_total = $cartItems->sum(function($item) {
                return $item->quantity * $item->price;
            });
            
            $cart_count = $cartItems->sum('quantity');
        }
        
        return response()->json([
            'success' => true,
            'cart_total' => $cart_total,
            'cart_count' => $cart_count,
            'message' => 'Produk dihapus dari keranjang'
        ]);
    }

    private function buildGuestCartItems(array $sessionCart): \Illuminate\Support\Collection
    {
        $productIds = collect($sessionCart)->pluck('product_id');
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');
        
        return collect($sessionCart)->map(function($item) use ($products) {
            $product = $products[$item['product_id']] ?? null;
            if (!$product) return null;
            return (object) [
                'id' => $item['product_id'],
                'product_id' => $item['product_id'],
                'product' => $product,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ];
        })->filter();
    }
}