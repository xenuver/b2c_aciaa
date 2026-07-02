<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class CustomerServiceMessage extends Model
{

    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'email', 'phone', 'subject', 'message', 
        'type', 'status', 'reply', 'replied_at'
    ];

    public function user()
{
    return $this->belongsTo(User::class);
}
}
