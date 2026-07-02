<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;

class Rating extends Model
{
    protected $fillable = [
        'user_id', 'product_id', 'transaction_id', 
        'rating', 'review', 'images', 'is_approved', 'admin_reply'
    ];

    protected $casts = [
        'images' => 'array',
        'is_approved' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
