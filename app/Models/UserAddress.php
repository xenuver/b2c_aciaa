<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class UserAddress extends Model
{

    use HasFactory;

    protected $fillable = [
        'user_id', 'label', 'recipient_name', 'phone', 'address', 
        'province', 'province_id', 'city', 'city_id', 'subdistrict_id', 'district', 'postal_code', 'is_default'
    ];

    public function user()
{
    return $this->belongsTo(User::class);
}
}
