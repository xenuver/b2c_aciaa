<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Transaction;
use App\Models\User;
use App\Models\ReturItem;

class Retur extends Model
{

    use HasFactory;

    protected $fillable = [
        'transaction_id', 'user_id', 'retur_number', 'reason', 'description', 
        'status', 'proof_image', 'admin_notes', 'approved_at', 'completed_at'
    ];


    public function transaction()
{
    return $this->belongsTo(Transaction::class);
}

public function transactionDetail()
{
    return $this->belongsTo(TransactionDetail::class);
}

public function user()
{
    return $this->belongsTo(User::class);
}

public function items()
{
    return $this->hasMany(ReturItem::class);
}
}
