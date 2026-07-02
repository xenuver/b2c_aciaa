<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingCost extends Model
{
    use HasFactory;

    protected $fillable = [
        'origin_city_id', 'destination_city_id', 'courier', 'service', 
        'description', 'cost', 'etd', 'expires_at'
    ];
}