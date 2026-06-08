<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OngkirController extends Controller
{
    // API Key kamu sudah aman terpasang di sini
    private $apiKey = 'nSNdkGRi0fb853de07ba1e2bCh6xe9zY'; 

    // 1. Ambil Provinsi
    public function getProvinces()
    {
        $response = Http::withoutVerifying()->withHeaders([
            'Accept' => 'application/json', // WAJIB ADA UNTUK KOMERCE
            'key'    => $this->apiKey
        ])->get('https://rajaongkir.komerce.id/api/v1/destination/province');
        
        return response()->json($response->json()['data'] ?? []);
    }

    // 2. Ambil Kota/Kabupaten
    public function getCities($provinceId)
    {
        $response = Http::withoutVerifying()->withHeaders([
            'Accept' => 'application/json', // WAJIB ADA
            'key'    => $this->apiKey
        ])->get("https://rajaongkir.komerce.id/api/v1/destination/city/{$provinceId}");
        
        return response()->json($response->json()['data'] ?? []);
    }

    // 3. Ambil Kecamatan
    public function getDistricts($cityId)
    {
        $response = Http::withoutVerifying()->withHeaders([
            'Accept' => 'application/json', // WAJIB ADA
            'key'    => $this->apiKey
        ])->get("https://rajaongkir.komerce.id/api/v1/destination/district/{$cityId}");
        
        return response()->json($response->json()['data'] ?? []);
    }

    // 4. Kalkulasi Ongkir
    public function checkCost(Request $request)
    {
        $response = Http::withoutVerifying()->withHeaders([
            'Accept' => 'application/json',
            'key'    => $this->apiKey
        ])->asForm()->post('https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost', [
            'origin'      => 5761, // ID Kecamatan Depok, Sleman
            'destination' => $request->district_id,
            'weight'      => 1000, // 1 kg
            'courier'     => $request->courier
        ]);
        
        $data = $response->json()['data'] ?? [];
        $cost = 0;
        
        // Membongkar Array Komerce V2
        if (!empty($data) && isset($data[0]['cost'])) {
            $cost = $data[0]['cost'];
        } elseif (!empty($data['calculate_reguler']) && isset($data['calculate_reguler'][0]['shipping_cost'])) {
            $cost = $data['calculate_reguler'][0]['shipping_cost'];
        }
        
        return response()->json([
            ['cost' => $cost]
        ]);
    }
}