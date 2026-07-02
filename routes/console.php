<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule untuk kirim email promo
Schedule::command('promo:send')->dailyAt('18:25');

// Schedule untuk cek transaksi expired
Schedule::command('app:check-expired-transactions')->everyTenMinutes();