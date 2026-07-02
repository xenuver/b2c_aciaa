<?php 

    return [
        'api_key' => env('RAJAONGKIR_API_KEY', ''),
        'origin' => env('RAJAONGKIR_ORIGIN', '365'), // ID kota toko (database lokal)
        'komerce_origin' => env('RAJAONGKIR_KOMERCE_ORIGIN', '513'), // ID kota Pontianak di API Komerce
        'origin_subdistrict' => env('RAJAONGKIR_ORIGIN_SUBDISTRICT', '4911'), // ID kecamatan toko (Pontianak Kota) di Komerce
        'default_weight' => 200, // gram per item
        'komerce_base_url' => env('RAJAONGKIR_KOMERCE_URL', 'https://rajaongkir.komerce.id/api/v1'),
        // Sembunyikan layanan kargo/trucking & motor — cocok untuk paket pakaian
        'excluded_service_patterns' => [
            '/^JTR/',   // JNE trucking
            '/^T\d+$/', // TIKI motor
            '/^TRC$/',  // TIKI trucking
        ],
    ];