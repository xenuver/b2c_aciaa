<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Voucher;
use App\Models\User;
use App\Models\Transaction;

class VoucherUsageLog extends Model
{

    use HasFactory;

    protected $fillable = [
        'voucher_id', 'voucher_code', 'user_id', 'transaction_id', 'discount_amount'
    ];

    public function voucher()
{
    return $this->belongsTo(Voucher::class);
}

public function user()
{
    return $this->belongsTo(User::class);
}

public function transaction()
{
    return $this->belongsTo(Transaction::class);
}
}
