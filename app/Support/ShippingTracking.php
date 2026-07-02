<?php

namespace App\Support;

class ShippingTracking
{
    public static function buildUrl(?string $courier, string $trackingNumber): ?string
    {
        $courier = strtolower(trim((string) $courier));
        $trackingNumber = trim($trackingNumber);

        if ($trackingNumber === '') {
            return null;
        }

        return match ($courier) {
            'jne' => 'https://www.jne.co.id/id/tracking/trace',
            'pos' => 'https://www.posindonesia.co.id/id/tracking',
            'tiki' => 'https://www.tiki.id/id/tracking',
            default => null,
        };
    }
}
