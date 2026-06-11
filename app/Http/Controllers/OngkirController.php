<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OngkirController extends Controller
{
    private string $apiKey;
    private string $originId;
    private string $baseUrl = 'https://rajaongkir.komerce.id/api/v1';

    public function __construct()
    {
        $this->apiKey = env('RAJAONGKIR_API_KEY', '0B2AOmN50f58f4fc31bcf676IK3LxaCz');
        $this->originId = env('RAJAONGKIR_ORIGIN_ID', '49083');
    }

    /**
     * Search destinasi by nama kota
     */
    public function searchDestination(Request $request)
    {
        $keyword = $request->get('name', '');

        if (strlen($keyword) < 2) {
            return response()->json(['data' => []]);
        }

        try {
            $response = Http::withOptions(['verify' => false, 'timeout' => 15])
                ->withHeaders(['key' => $this->apiKey])
                ->get("{$this->baseUrl}/destination/domestic-destination", [
                    'search' => $keyword,
                    'limit' => 10,
                    'offset' => 0,
                ]);

            if ($response->successful()) {
                $json = $response->json();

                $results = collect($json['data'] ?? [])
                    ->map(fn($item) => [
                        'id' => $item['id'] ?? '',
                        'label' => $item['label'] ?? '',
                    ])
                    ->filter(fn($item) => $item['id'] !== '')
                    ->values();

                return response()->json(['data' => $results]);
            }

            return response()->json([
                'data' => [],
                'message' => 'Gagal: ' . $response->body(),
            ]);

        } catch (\Exception $e) {
            return response()->json(['data' => [], 'error' => $e->getMessage()]);
        }
    }

    /**
     * Hitung ongkir
     */
    public function calculate(Request $request)
    {
        $request->validate([
            'destination_id' => 'required',
            'weight' => 'required|numeric|min:1',
            'courier' => 'nullable|string',
        ]);

        try {
            $courier = $request->courier ?? 'jne:tiki:pos:sicepat';

            $response = Http::withOptions(['verify' => false, 'timeout' => 15])
                ->withHeaders(['key' => $this->apiKey])
                ->asForm()
                ->post("{$this->baseUrl}/calculate/domestic-cost", [
                    'origin' => $this->originId,
                    'destination' => $request->destination_id,
                    'weight' => (int) $request->weight,
                    'courier' => $courier,
                ]);

            if ($response->successful()) {
                $json = $response->json();
                $services = [];

                // Struktur response Komerce: data[] flat, bukan nested costs
                foreach ($json['data'] ?? [] as $item) {
                    $services[] = [
                        'service_name' => strtoupper($item['code'] ?? '') . ' ' . ($item['service'] ?? '') . ' - ' . ($item['description'] ?? ''),
                        'etd' => $item['etd'] ?? '-',
                        'price' => $item['cost'] ?? 0,
                    ];
                }

                return response()->json(['data' => $services]);
            }

            return response()->json([
                'data' => [],
                'message' => 'Gagal menghitung ongkir: ' . $response->body(),
            ]);

        } catch (\Exception $e) {
            return response()->json(['data' => [], 'error' => $e->getMessage()]);
        }
    }

    /**
     * Get daftar provinsi
     */
    public function getProvinces()
    {
        try {
            $response = Http::withOptions(['verify' => false, 'timeout' => 15])
                ->withHeaders(['key' => $this->apiKey])
                ->get("{$this->baseUrl}/destination/province");

            return response()->json($response->json());

        } catch (\Exception $e) {
            return response()->json(['data' => [], 'error' => $e->getMessage()]);
        }
    }

    /**
     * Get daftar kota by provinsi
     */
    public function getCities(Request $request)
    {
        try {
            $response = Http::withOptions(['verify' => false, 'timeout' => 15])
                ->withHeaders(['key' => $this->apiKey])
                ->get("{$this->baseUrl}/destination/city", [
                    'province_id' => $request->get('province_id', ''),
                ]);

            return response()->json($response->json());

        } catch (\Exception $e) {
            return response()->json(['data' => [], 'error' => $e->getMessage()]);
        }
    }
}