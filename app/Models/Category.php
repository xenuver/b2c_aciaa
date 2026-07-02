<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Product;

class Category extends Model // Pastikan nama class sesuai dengan file (misal: Category.php)
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'icon', 'order', 'is_active'
    ];
    /**
     * Relasi One-to-Many ke model Product.
     */
   // Di dalam class Category, tambahkan:

public function products()
{
    return $this->hasMany(Product::class);
}

}