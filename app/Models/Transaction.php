<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Voucher;
use App\Models\TransactionDetail;
use App\Models\Retur;
use App\Models\VoucherUsageLog;

class Transaction extends Model
{

    use HasFactory;

    protected $fillable = [
        'user_id', 'voucher_id', 'invoice_number', 'subtotal', 'shipping_cost', 
        'discount_amount', 'grand_total', 'status', 'payment_status', 
        'midtrans_order_id', 'midtrans_transaction_id', 'payment_method', 
        'snap_token', 'snap_url', 'payment_expired_at',
        'shipping_courier', 'shipping_service', 'shipping_etd', 'tracking_number', 'tracking_url',
        'shipping_address', 'recipient_name', 'recipient_phone', 'notes', 'paid_at', 'shipped_at', 'delivered_at'
    ];

     protected $casts = [
        'paid_at' => 'datetime',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
        'payment_expired_at' => 'datetime'
    ];

    /**
     * Check if the payment deadline has passed.
     */
    public function isPaymentExpired(): bool
    {
        if ($this->payment_status === 'paid' || $this->payment_status === 'failed') {
            return false;
        }

        if ($this->payment_status === 'expired') {
            return true;
        }

        return $this->payment_expired_at && $this->payment_expired_at->isPast();
    }

   public function user()
{
    return $this->belongsTo(User::class);
}

public function voucher()
{
    return $this->belongsTo(Voucher::class);
}

public function details()
{
    return $this->hasMany(TransactionDetail::class);
}

public function retur()
{
    return $this->hasOne(Retur::class);
}

public function voucherUsageLog()
{
    return $this->hasOne(VoucherUsageLog::class);
}

    public function getResolvedTrackingUrlAttribute(): ?string
    {
        if ($this->tracking_url) {
            return $this->tracking_url;
        }

        if (!$this->tracking_number) {
            return null;
        }

        return \App\Support\ShippingTracking::buildUrl($this->shipping_courier, $this->tracking_number);
    }

 // Generate invoice number otomatis
    public static function generateInvoiceNumber()
    {
        $latest = self::latest('id')->first();
        $number = $latest ? intval(substr($latest->invoice_number, -6)) + 1 : 1;
        return 'INV/' . date('Ymd') . '/' . str_pad($number, 6, '0', STR_PAD_LEFT);
    }
}
