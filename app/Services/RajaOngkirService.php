<?php

namespace App\Services;

use App\Models\City;
use App\Models\ShippingCost;
use App\Models\Subdistrict;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RajaOngkirService
{
    protected $apiKey;
    protected $origin;

    public function __construct()
    {
        $this->apiKey = config('rajaongkir.api_key');
        $this->origin = config('rajaongkir.origin', '365'); // Default: Kota Pontianak
    }

    /**
     * Get shipping cost services from RajaOngkir
     *
     * @param string $destinationCityId
     * @param int $weight Weight in grams
     * @param string $courier jne, pos, or tiki
     * @param int|null $destinationSubdistrictId ID kecamatan tujuan (Komerce) untuk tarif lebih akurat
     * @return array
     */
    public function getCost($destinationCityId, $weight, $courier, ?int $destinationSubdistrictId = null)
    {
        $weight = max((int) $weight, 100);
        $courier = strtolower($courier);
        $localOriginId = (int) $this->origin;
        $localDestId = $this->resolveCanonicalLocalCityId($destinationCityId);

        if (empty($this->apiKey)) {
            Log::error('RajaOngkir: API key tidak dikonfigurasi');
            return [];
        }

        // Untuk rute dalam kota (origin city == destination city), cache sebelumnya bisa "nyangkut"
        // pada REG mahal dari perhitungan kecamatan yang sama. Kita bypass cache agar selalu dapat CTC yang wajar.
        $shouldBypassCache = ($localOriginId === $localDestId);

        if (!$shouldBypassCache) {
            // Cache berdasarkan ID kota lokal (asal toko → tujuan konsumen)
            $cachedCosts = ShippingCost::where('origin_city_id', $localOriginId)
                ->where('destination_city_id', $localDestId)
                ->where('courier', $courier)
                ->where('expires_at', '>', now())
                ->where('description', 'not like', '%Offline Fallback%')
                ->get();

            if ($cachedCosts->isNotEmpty()) {
                $fromCache = $this->formatCostRows($cachedCosts->map(fn ($item) => [
                    'service' => $item->service,
                    'description' => $item->description,
                    'cost' => (int) $item->cost,
                    'etd' => $item->etd,
                    'code' => $courier,
                ])->toArray());

                // Cache lama (hanya CTC dari API kota) — ambil ulang via API kecamatan
                if (!empty($fromCache) && !$this->shouldRefreshCostCache($fromCache)) {
                    return $fromCache;
                }
            }
        }

        $komerceOrigin = (int) config('rajaongkir.komerce_origin');
        if (!$komerceOrigin) {
            $originCity = City::with('province')->find($localOriginId);
            $komerceOrigin = $this->resolveKomerceCityIdFromLocal($originCity) ?? 0;
        }

        $destCity = City::with('province')->find($localDestId);
        $komerceDest = $this->resolveKomerceCityIdFromLocal($destCity) ?? 0;

        if (!$komerceOrigin || !$komerceDest) {
            Log::warning('RajaOngkir: gagal memetakan kota asal/tujuan ke Komerce', [
                'local_origin' => $localOriginId,
                'local_destination' => $localDestId,
                'komerce_origin' => $komerceOrigin,
                'komerce_destination' => $komerceDest,
            ]);
            return [];
        }

        $formattedCosts = [];
        $originDistrictId = (int) config('rajaongkir.origin_subdistrict');
        $destinationDistrictId = $this->resolveDestinationDistrictId($localDestId, $destinationSubdistrictId);

        // Hindari perhitungan district->district jika origin dan destination kecamatan sama.
        // Pada beberapa rute, API mengembalikan REG mahal dan menghilangkan opsi CTC/CTCYES.
        if ($originDistrictId && $destinationDistrictId && $originDistrictId !== $destinationDistrictId) {
            $formattedCosts = $this->fetchCostFromKomerceByDistrict(
                $originDistrictId,
                $destinationDistrictId,
                $weight,
                $courier
            );
        }

        if (empty($formattedCosts)) {
            $formattedCosts = $this->fetchCostFromKomerce($komerceOrigin, $komerceDest, $weight, $courier);
        }

        // Fallback to standard RajaOngkir API if Komerce API fails or is disabled
        if (empty($formattedCosts)) {
            $formattedCosts = $this->fetchCostFromStandardRajaOngkir($localOriginId, $localDestId, $weight, $courier);
        }

        foreach ($formattedCosts as $item) {
            ShippingCost::updateOrCreate(
                [
                    'origin_city_id' => $localOriginId,
                    'destination_city_id' => $localDestId,
                    'courier' => $courier,
                    'service' => $item['service'],
                ],
                [
                    'description' => $item['description'],
                    'cost' => $item['cost'],
                    'etd' => $item['etd'],
                    'expires_at' => now()->addDays(1),
                ]
            );
        }

        return $formattedCosts;
    }

    /**
     * @return array<int, array{service: string, description: string, cost: int, etd: string}>
     */
    protected function fetchCostFromKomerce(int $originId, int $destinationId, int $weight, string $courier): array
    {
        try {
            $baseUrl = rtrim(config('rajaongkir.komerce_base_url'), '/');
            $response = Http::withHeaders(['Key' => $this->apiKey])
                ->timeout(25)
                ->asForm()
                ->post("{$baseUrl}/calculate/domestic-cost", [
                    'origin' => $originId,
                    'destination' => $destinationId,
                    'weight' => $weight,
                    'courier' => $courier,
                ]);

            if (!$response->successful()) {
                Log::error('RajaOngkir Komerce cost error: ' . $response->body());
                return [];
            }

            return $this->parseKomerceCostRows($response->json('data') ?? []);
        } catch (\Exception $e) {
            Log::error('RajaOngkir Komerce cost exception: ' . $e->getMessage());
            return [];
        }
    }

    protected function fetchCostFromStandardRajaOngkir(int $originId, int $destinationId, int $weight, string $courier): array
    {
        try {
            $response = Http::withHeaders(['key' => $this->apiKey])
                ->timeout(25)
                ->asForm()
                ->post("https://api.rajaongkir.com/starter/cost", [
                    'origin' => $originId,
                    'destination' => $destinationId,
                    'weight' => $weight,
                    'courier' => $courier,
                ]);

            if (!$response->successful()) {
                Log::error('RajaOngkir Standard cost error: ' . $response->body());
                return [];
            }

            $results = $response->json('rajaongkir.results.0.costs') ?? [];
            
            $parsed = collect($results)
                ->map(fn ($row) => [
                    'service' => (string) ($row['service'] ?? ''),
                    'description' => (string) ($row['description'] ?? ''),
                    'cost' => (int) ($row['cost'][0]['value'] ?? 0),
                    'etd' => (string) ($row['cost'][0]['etd'] ?? ''),
                    'code' => $courier,
                ])
                ->filter(fn ($row) => $row['service'] !== '' && $row['cost'] > 0)
                ->values()
                ->all();
                
            return $this->formatCostRows($parsed);
        } catch (\Exception $e) {
            Log::error('RajaOngkir Standard exception: ' . $e->getMessage());
            return [];
        }
    }

    protected function fetchCostFromKomerceByDistrict(
        int $originDistrictId,
        int $destinationDistrictId,
        int $weight,
        string $courier
    ): array {
        try {
            $baseUrl = rtrim(config('rajaongkir.komerce_base_url'), '/');
            $response = Http::withHeaders(['Key' => $this->apiKey])
                ->timeout(25)
                ->asForm()
                ->post("{$baseUrl}/calculate/district/domestic-cost", [
                    'origin' => $originDistrictId,
                    'destination' => $destinationDistrictId,
                    'weight' => $weight,
                    'courier' => $courier,
                ]);

            if (!$response->successful()) {
                Log::warning('RajaOngkir Komerce district cost fallback ke city: ' . $response->body());
                return [];
            }

            return $this->parseKomerceCostRows($response->json('data') ?? []);
        } catch (\Exception $e) {
            Log::warning('RajaOngkir Komerce district cost exception: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * @param array<int, array<string, mixed>> $rows
     * @return array<int, array{service: string, description: string, cost: int, etd: string, code?: string}>
     */
    protected function parseKomerceCostRows(array $rows): array
    {
        $parsed = collect($rows)
            ->map(fn ($row) => [
                'service' => (string) ($row['service'] ?? ''),
                'description' => (string) ($row['description'] ?? ''),
                'cost' => (int) ($row['cost'] ?? 0),
                'etd' => (string) ($row['etd'] ?? ''),
                'code' => (string) ($row['code'] ?? ''),
            ])
            ->filter(fn ($row) => $row['service'] !== '' && $row['cost'] > 0)
            ->values()
            ->all();

        return $this->formatCostRows($parsed);
    }

    /**
     * @param array<int, array{service: string, description: string, cost: int, etd: string, code?: string}> $rows
     * @return array<int, array{service: string, description: string, cost: int, etd: string}>
     */
    protected function formatCostRows(array $rows): array
    {
        return collect($rows)
            ->filter(fn ($row) => !$this->isExcludedService($row['service']))
            ->map(fn ($row) => [
                'service' => $row['service'],
                'description' => $this->enhanceServiceDescription($row['service'], $row['description']),
                'cost' => $row['cost'],
                'etd' => $row['etd'],
            ])
            ->unique(fn ($row) => strtoupper($row['service']))
            ->sortBy('cost')
            ->values()
            ->all();
    }

    protected function isExcludedService(string $service): bool
    {
        $service = strtoupper(trim($service));
        $patterns = config('rajaongkir.excluded_service_patterns', []);

        foreach ($patterns as $pattern) {
            if (@preg_match($pattern, $service)) {
                return true;
            }
        }

        return false;
    }

    protected function enhanceServiceDescription(string $service, string $description): string
    {
        $labels = [
            'REG' => 'Layanan Reguler (Standar)',
            'CTC' => 'Layanan Reguler Dalam Kota',
            'CTCYES' => 'Layanan Kilat (YES) - Dalam Kota',
            'CTCSPS' => 'Layanan Super Speed (SPS) - Dalam Kota',
            'OKE' => 'Layanan Ekonomis (OKE)',
            'YES' => 'Layanan Kilat (YES)',
            'SPS' => 'Layanan Super Speed (SPS)',
            'ECO' => 'Layanan Ekonomis',
            '240' => 'Pos Reguler',
            '447' => 'Pos Kilat (Next Day)',
        ];

        $serviceKey = strtoupper(trim($service));

        return $labels[$serviceKey] ?? ($description ?: $service);
    }

    /**
     * Cache lama dari API kota sering hanya berisi CTC — paksa hitung ulang via kecamatan.
     *
     * @param array<int, array{service: string}> $rows
     */
    protected function shouldRefreshCostCache(array $rows): bool
    {
        if (count($rows) <= 1) {
            $only = strtoupper($rows[0]['service'] ?? '');
            if (in_array($only, ['CTC', ''], true)) {
                return true;
            }
        }

        return false;
    }

    protected function resolveDestinationDistrictId(int $localCityId, ?int $subdistrictId): ?int
    {
        if ($subdistrictId) {
            // If it's already a Komerce district id (typically 4 digits+), use it directly.
            if ($subdistrictId >= 1000) {
                return $subdistrictId;
            }

            // Legacy seeded IDs (e.g. 1..6 for Pontianak) must be mapped by name to Komerce district ID.
            $local = Subdistrict::where('id', $subdistrictId)->where('city_id', $localCityId)->first();
            if ($local) {
                $mapped = $this->resolveKomerceDistrictIdByName($localCityId, $local->name);
                if ($mapped) {
                    return $mapped;
                }
            }
        }

        // If user didn't select kecamatan, pick a sane default for this city.
        $localDistrict = Subdistrict::where('city_id', $localCityId)->orderBy('name')->first();
        if ($localDistrict) {
            if ((int) $localDistrict->id >= 1000) {
                return (int) $localDistrict->id;
            }

            $mapped = $this->resolveKomerceDistrictIdByName($localCityId, $localDistrict->name);
            if ($mapped) {
                return $mapped;
            }
        }

        return $this->resolveDefaultKomerceDistrictId($localCityId);
    }

    protected function resolveDefaultKomerceDistrictId(int $localCityId): ?int
    {
        $city = City::with('province')->find($localCityId);
        if (!$city) {
            return null;
        }

        $komerceCityId = $this->resolveKomerceCityIdFromLocal($city);
        if (!$komerceCityId) {
            return null;
        }

        $cacheKey = 'rajaongkir.komerce.district.default.' . $komerceCityId;

        return Cache::remember($cacheKey, now()->addDays(7), function () use ($komerceCityId, $city) {
            $response = $this->komerceGet("/destination/district/{$komerceCityId}");
            $districts = $response['data'] ?? [];

            if (empty($districts)) {
                return null;
            }

            $cityName = $this->normalizeLocationName($city->name);

            foreach ($districts as $district) {
                $districtName = $this->normalizeLocationName($district['name'] ?? '');
                if (str_contains($districtName, $cityName) || str_contains($districtName, 'KOTA')) {
                    return (int) $district['id'];
                }
            }

            return (int) $districts[0]['id'];
        });
    }

    protected function resolveKomerceDistrictIdByName(int $localCityId, string $districtName): ?int
    {
        $city = City::with('province')->find($localCityId);
        if (!$city) {
            return null;
        }

        $komerceCityId = $this->resolveKomerceCityIdFromLocal($city);
        if (!$komerceCityId) {
            return null;
        }

        $needle = $this->normalizeLocationName($districtName);
        if ($needle === '') {
            return null;
        }

        $cacheKey = 'rajaongkir.komerce.district.map.' . $komerceCityId . '.' . md5($needle);

        return Cache::remember($cacheKey, now()->addDays(30), function () use ($komerceCityId, $needle) {
            $response = $this->komerceGet("/destination/district/{$komerceCityId}");
            $districts = $response['data'] ?? [];

            foreach ($districts as $district) {
                $name = $this->normalizeLocationName($district['name'] ?? '');
                if ($name === $needle) {
                    return (int) $district['id'];
                }
            }

            // fallback: contains match
            foreach ($districts as $district) {
                $name = $this->normalizeLocationName($district['name'] ?? '');
                if ($name !== '' && (str_contains($name, $needle) || str_contains($needle, $name))) {
                    return (int) $district['id'];
                }
            }

            return null;
        });
    }

    protected function resolveKomerceCityIdFromLocal(?City $city): ?int
    {
        if (!$city || !$city->province) {
            return null;
        }

        $komerceProvinceId = $this->resolveKomerceProvinceId($city->province->name);
        if (!$komerceProvinceId) {
            return null;
        }

        return $this->resolveKomerceCityId($komerceProvinceId, $city->name);
    }

    protected function resolveCanonicalLocalCityId(int|string $cityId): int
    {
        $city = City::find($cityId);
        if (!$city) {
            return (int) $cityId;
        }

        $withSubdistricts = City::where('province_id', $city->province_id)
            ->where('name', $city->name)
            ->where('type', $city->type)
            ->whereHas('subdistricts')
            ->orderByDesc('id')
            ->first();

        if ($withSubdistricts) {
            return (int) $withSubdistricts->id;
        }

        $newest = City::where('province_id', $city->province_id)
            ->where('name', $city->name)
            ->where('type', $city->type)
            ->orderByDesc('id')
            ->first();

        return $newest ? (int) $newest->id : (int) $city->id;
    }

    /**
     * Fetch kecamatan (district) from RajaOngkir Komerce API and cache to local DB.
     */
    public function syncDistrictsForCity(int $localCityId): bool
    {
        $city = City::with('province')->find($localCityId);
        if (!$city || !$city->province) {
            return false;
        }

        $districts = $this->fetchDistrictsFromKomerce($city);
        if (empty($districts)) {
            return false;
        }

        $now = now();
        foreach ($districts as $district) {
            Subdistrict::updateOrCreate(
                ['id' => $district['id']],
                [
                    'city_id' => $localCityId,
                    'name' => $district['name'],
                    'updated_at' => $now,
                ]
            );
        }

        Cache::put("rajaongkir.districts.{$localCityId}", true, now()->addDays(7));

        return true;
    }

    /**
     * @return array<int, array{id: int, name: string}>
     */
    protected function fetchDistrictsFromKomerce(City $city): array
    {
        if (empty($this->apiKey)) {
            return [];
        }

        $cacheKey = 'rajaongkir.komerce.districts.' . $city->province_id . '.' . mb_strtolower($city->name);

        return Cache::remember($cacheKey, now()->addDays(7), function () use ($city) {
            $komerceProvinceId = $this->resolveKomerceProvinceId($city->province->name);
            if (!$komerceProvinceId) {
                Log::warning('RajaOngkir Komerce: provinsi tidak ditemukan', ['name' => $city->province->name]);
                return [];
            }

            $komerceCityId = $this->resolveKomerceCityId($komerceProvinceId, $city->name);
            if (!$komerceCityId) {
                Log::warning('RajaOngkir Komerce: kota tidak ditemukan', [
                    'province_id' => $komerceProvinceId,
                    'city' => $city->name,
                ]);
                return [];
            }

            $response = $this->komerceGet("/destination/district/{$komerceCityId}");
            $rows = $response['data'] ?? [];

            return collect($rows)
                ->map(fn ($row) => [
                    'id' => (int) ($row['id'] ?? 0),
                    'name' => $this->formatDistrictName($row['name'] ?? ''),
                ])
                ->filter(fn ($row) => $row['id'] > 0 && $row['name'] !== '')
                ->values()
                ->all();
        });
    }

    protected function resolveKomerceProvinceId(string $provinceName): ?int
    {
        $response = $this->komerceGet('/destination/province');
        $provinces = $response['data'] ?? [];

        foreach ($provinces as $province) {
            if ($this->locationNamesMatch($provinceName, $province['name'] ?? '')) {
                return (int) $province['id'];
            }
        }

        return null;
    }

    protected function resolveKomerceCityId(int $komerceProvinceId, string $cityName): ?int
    {
        $response = $this->komerceGet("/destination/city/{$komerceProvinceId}");
        $cities = $response['data'] ?? [];

        foreach ($cities as $komerceCity) {
            if ($this->locationNamesMatch($cityName, $komerceCity['name'] ?? '')) {
                return (int) $komerceCity['id'];
            }
        }

        return null;
    }

    /**
     * @return array<string, mixed>
     */
    protected function komerceGet(string $path): array
    {
        try {
            $baseUrl = rtrim(config('rajaongkir.komerce_base_url'), '/');
            $response = Http::withHeaders(['Key' => $this->apiKey])
                ->timeout(20)
                ->get("{$baseUrl}{$path}");

            if ($response->successful()) {
                return $response->json() ?? [];
            }

            Log::error('RajaOngkir Komerce API Error: ' . $response->body());
        } catch (\Exception $e) {
            Log::error('RajaOngkir Komerce Exception: ' . $e->getMessage());
        }

        return [];
    }

    protected function locationNamesMatch(string $localName, string $komerceName): bool
    {
        $local = $this->normalizeLocationName($localName);
        $remote = $this->normalizeLocationName($komerceName);

        if ($local === '' || $remote === '') {
            return false;
        }

        return $local === $remote
            || str_contains($remote, $local)
            || str_contains($local, $remote);
    }

    protected function normalizeLocationName(string $name): string
    {
        $name = preg_replace('/\s*\([^)]*\)/u', '', $name) ?? $name;
        $name = preg_replace('/^(kota|kabupaten|kab\.?)\s+/iu', '', $name) ?? $name;

        return mb_strtoupper(trim(preg_replace('/\s+/u', ' ', $name) ?? $name));
    }

    protected function formatDistrictName(string $name): string
    {
        $name = mb_strtolower(trim($name));

        return mb_convert_case($name, MB_CASE_TITLE, 'UTF-8');
    }
}
