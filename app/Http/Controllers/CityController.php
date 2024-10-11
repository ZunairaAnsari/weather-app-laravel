<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CityController extends Controller
{
    public function getCities(Request $request)
    {
        $query = $request->input('query');
        $apiKey = env('WEATHER_API_KEY'); // Replace with your actual API key
        $response = Http::get("https://api.openweathermap.org/data/2.5/find", [
            'q' => $query,
            'appid' => $apiKey,
            'units' => 'metric',
            'type' => 'like',
            'cnt' => 5 // Limit the number of results
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $cities = array_map(function ($city) {
                return ['name' => $city['name']];
            }, $data['list']);

            return response()->json($cities);
        }

        return response()->json([]); // Return an empty array if no cities found
    }

}
