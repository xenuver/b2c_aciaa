<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_date', 'total_sales', 'total_discount', 'total_shipping', 
        'net_sales', 'total_orders', 'total_customers'
    ];
}