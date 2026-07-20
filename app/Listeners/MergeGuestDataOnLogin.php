<?php

namespace App\Listeners;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Wishlist;
use Illuminate\Auth\Events\Login;

class MergeGuestDataOnLogin
{
    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $user = $event->user;

        // 1. Merge Guest Cart to Database
        $guestCart = session('guest_cart', []);
        if (!empty($guestCart)) {
            $cart = Cart::firstOrCreate(['user_id' => $user->id]);
            foreach ($guestCart as $item) {
                $existing = CartItem::where('cart_id', $cart->id)
                    ->where('product_id', $item['product_id'])
                    ->first();

                if ($existing) {
                    $existing->quantity += $item['quantity'];
                    $existing->save();
                } else {
                    CartItem::create([
                        'cart_id' => $cart->id,
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                    ]);
                }
            }
            session()->forget('guest_cart');
        }

        // 2. Merge Guest Wishlist to Database
        $guestWishlist = session('guest_wishlist', []);
        if (!empty($guestWishlist)) {
            foreach ($guestWishlist as $productId) {
                Wishlist::firstOrCreate([
                    'user_id' => $user->id,
                    'product_id' => $productId,
                ]);
            }
            session()->forget('guest_wishlist');
        }
    }
}
