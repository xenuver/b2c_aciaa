<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailySalesSummary extends Model
{
    use HasFactory;

    protected $fillable = [
        'date', 'total_transactions', 'total_revenue', 'total_products_sold', 'average_order_value'
    ];
}