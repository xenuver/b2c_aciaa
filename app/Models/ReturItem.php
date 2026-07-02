<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Retur;
use App\Models\TransactionDetail;

class ReturItem extends Model
{

    use HasFactory;

    protected $fillable = [
        'retur_id', 'transaction_detail_id', 'quantity', 'refund_amount'
    ];


    public function retur()
{
    return $this->belongsTo(Retur::class);
}

public function transactionDetail()
{
    return $this->belongsTo(TransactionDetail::class);
}
}
