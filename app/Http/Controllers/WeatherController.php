<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    //
    public function search(Request $request)
    {
        // Validate the city input
        $request->validate([
            'city' => 'required|string',
        ]);

        // Fetch weather data from the external API (e.g., OpenWeatherMap)
        $apiKey = env('WEATHER_API_KEY'); // Store your API key in the .env file
        $city = $request->city;

        $response = Http::get("https://api.openweathermap.org/data/2.5/weather", [
            'q' => $city,
            'appid' => $apiKey,
            'units' => 'metric',
        ]);

        // Check if the API call was successful
        if ($response->successful()) {
            $data = $response->json();

            // Prepare the weather data for the view
            $weather = [
                'name' => $data['name'],
                'description' => ucfirst($data['weather'][0]['description']),
                'temperature' => $data['main']['temp'],
                'humidity' => $data['main']['humidity'],
                'wind_speed' => $data['wind']['speed'],
                'feels_like' => $data['main']['feels_like'],
            ];

            return view('dashboard', compact('weather'));
        } else {
            // Handle city not found error or API failure
            return redirect()->back()->withErrors(['city' => 'City not found or API error.']);
        }
    }
}
