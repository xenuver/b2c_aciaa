<?php

/*
|--------------------------------------------------------------------------
| Midtrans (dibaca dari .env)
|--------------------------------------------------------------------------
|
| Isi kredensial di file .env (bukan .env.example):
|   MIDTRANS_MERCHANT_ID=
|   MIDTRANS_CLIENT_KEY=
|   MIDTRANS_SERVER_KEY=
|   MIDTRANS_IS_PRODUCTION=false
|   MIDTRANS_IS_3DS=true
|
*/

$isProduction = filter_var(env('MIDTRANS_IS_PRODUCTION', false), FILTER_VALIDATE_BOOLEAN);

return [
    'merchant_id' => trim((string) env('MIDTRANS_MERCHANT_ID', ''), " \t\n\r\0\x0B'\""),
    'client_key' => trim((string) env('MIDTRANS_CLIENT_KEY', ''), " \t\n\r\0\x0B'\""),
    'server_key' => trim((string) env('MIDTRANS_SERVER_KEY', ''), " \t\n\r\0\x0B'\""),
    'is_production' => $isProduction,
    'is_3ds' => filter_var(env('MIDTRANS_IS_3DS', true), FILTER_VALIDATE_BOOLEAN),
    'snap_url' => $isProduction
        ? 'https://app.midtrans.com/snap/snap.js'
        : 'https://app.sandbox.midtrans.com/snap/snap.js',
    'notification_url' => rtrim((string) env('APP_URL', 'http://localhost'), '/') . '/midtrans/notification',
];
