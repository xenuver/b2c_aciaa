<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Province;
use App\Models\City;
use App\Models\Subdistrict;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seed Provinces
        if (Province::count() == 0) {
            $provincesJson = File::get(database_path('data/provinces.json'));
        $provinces = json_decode($provincesJson, true);
        
        $provinceData = [];
        foreach ($provinces as $province) {
            $provinceData[] = [
                'id' => $province['id'],
                'name' => $province['name'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        // Chunk to insert in case of large data, but provinces are only 34
        Province::insert($provinceData);
        }

        // 2. Seed Cities
        if (City::count() == 0) {
            $citiesJson = File::get(database_path('data/cities.json'));
        $cities = json_decode($citiesJson, true);
        
        $cityChunks = array_chunk($cities, 100);
        foreach ($cityChunks as $chunk) {
            $cityData = [];
            foreach ($chunk as $city) {
                $cityData[] = [
                    'id' => $city['id'],
                    'province_id' => $city['province_id'],
                    'name' => $city['name'],
                    'type' => $city['type'],
                    'postal_code' => $city['postal_code'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            City::insert($cityData);
        }
        }

        // 3. Seed Subdistricts
        if (Subdistrict::count() == 0) {
            $subdistrictsJson = File::get(database_path('data/subdistricts.json'));
        $subdistricts = json_decode($subdistrictsJson, true);
        
        $subdistrictChunks = array_chunk($subdistricts, 100);
        foreach ($subdistrictChunks as $chunk) {
            $subdistrictData = [];
            foreach ($chunk as $subdistrict) {
                $subdistrictData[] = [
                    'id' => $subdistrict['id'],
                    'city_id' => $subdistrict['city_id'],
                    'name' => $subdistrict['name'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            Subdistrict::insert($subdistrictData);
        }
        }
    }
}
