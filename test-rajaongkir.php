<?php

$apiKey = "wFauJ2bP514d9a3b8291690bzXdjCqfY";

$urls = [
    'starter' => 'https://api.rajaongkir.com/starter/province',
    'basic' => 'https://api.rajaongkir.com/basic/province',
    'pro' => 'https://api.rajaongkir.com/pro/province'
];

foreach ($urls as $type => $url) {
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "key: " . $apiKey
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    echo "--- TYPE: $type ---\n";
    if ($err) {
        echo "cURL Error #:" . $err . "\n";
    } else {
        $data = json_decode($response, true);
        $status = $data['rajaongkir']['status']['code'] ?? 'unknown';
        $desc = $data['rajaongkir']['status']['description'] ?? 'unknown';
        echo "Status: $status ($desc)\n";
        if ($status == 200) {
            echo "SUCCESS! Sample response: " . substr($response, 0, 200) . "...\n";
        } else {
            echo "Response: $response\n";
        }
    }
}
