<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// Import model lain jika berada di namespace berbeda, 
// namun jika dalam satu folder App\Models, ini opsional.
use App\Models\Category;
use App\Models\CartItem;
use App\Models\TransactionDetail;
use App\Models\Rating;
use App\Models\Wishlist;
use App\Models\Stock;

class Product extends Model
{
    use HasFactory;

     protected $fillable = [
        'category_id', 'name', 'slug', 'description', 'price', 'discount_price', 
        'stock', 'image', 'gallery', 'sku', 'is_promo', 'is_active', 'views_count', 'sold_count'
    ];

    // Relasi ke Category (Many-to-One)
   public function category()
{
    return $this->belongsTo(\App\Models\Category::class);
}

public function cartItems()
{
    return $this->hasMany(CartItem::class);
}

public function transactionDetails()
{
    return $this->hasMany(TransactionDetail::class);
}

public function ratings()
{
    return $this->hasMany(Rating::class);
}

public function getAverageRatingAttribute()
{
    return $this->ratings()->where('is_approved', 1)->avg('rating') ?? 0;
}

public function getRatingCountAttribute()
{
    return $this->ratings()->where('is_approved', 1)->count();
}

public function wishlists()
{
    return $this->hasMany(Wishlist::class);
}

public function isInWishlist()
{
    if (!auth()->check()) {
        return in_array($this->id, session('guest_wishlist', []));
    }
    return $this->wishlists()->where('user_id', auth()->id())->exists();
}

public function stocks()
{
    return $this->hasMany(Stock::class);
}

// TAMBAHKAN METHOD INI
    public function decreaseStock($quantity)
    {
        $this->stock -= $quantity;
        $this->sold_count += $quantity;
        $this->save();
    }

    // TAMBAHKAN METHOD INI (opsional, untuk menambah stok)
    public function increaseStock($quantity)
    {
        $this->stock += $quantity;
        $this->save();
    }

    // Aksesor untuk mendapatkan harga final (setelah diskon)
    public function getFinalPriceAttribute()
    {
        return $this->discount_price ?? $this->price;
    }
}