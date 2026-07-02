<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subdistrict extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'city_id', 'name'];

    public $incrementing = false;

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
