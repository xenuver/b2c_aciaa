<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Transaction;
use App\Models\UserVoucher;
use App\Models\VoucherUsageLog;

class Voucher extends Model
{

  use HasFactory;

    protected $fillable = [
        'code', 'name', 'description', 'type', 'value', 'min_purchase', 'min_qty',
        'max_discount', 'max_usage', 'used_count', 'start_date', 'expiry_date', 'is_active',
        'user_type', 'min_completed_orders'
    ];

   public function transactions()
{
    return $this->hasMany(Transaction::class);
}

public function userVouchers()
{
    return $this->hasMany(UserVoucher::class);
}

public function usageLogs()
{
    return $this->hasMany(VoucherUsageLog::class);
}
}
