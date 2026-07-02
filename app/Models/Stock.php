<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Product;
use App\Models\User;

class Stock extends Model
{

    use HasFactory;

    protected $fillable = [
        'product_id', 'quantity', 'type', 'description', 'created_by'
    ];


    // Relasi ke produk
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relasi ke user yang melakukan mutasi stok
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
