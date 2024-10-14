@extends('layout')

@section('content')

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">
        <a class="navbar-brand text-white" href="#">WeatherApp</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Welcome {{ Auth()->user()->name }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Weather Forecast</a>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Weather Dashboard & Currency Exchange -->
<div class="App" id="weatherApp">
    <h2 class="heading">Weather Forecast & Currency Exchange Rates</h2>
    <div class="container">
    <!-- Search Bar -->
    <div class="search-bar">
        <form method="POST" action="{{ route('search') }}" id="searchForm">
            @csrf
            <input type="text" name="city" id="cityInput" placeholder="Enter city..." style="color: white" value="{{ old('city') }}" required />
        </form>
    </div>

    <!-- Grid Layout for Weather Data and Exchange Rates -->
    <div class="grid-container">
        <!-- Weather Data Section -->
        <div class="weather-data">
            @if(isset($weather))
                <div class="location"><p>{{ $weather['name'] }}</p></div>
                <div class="temperature"><h1>{{ $weather['temperature'] }}°C</h1></div>
                <div class="description"><p>{{ $weather['description'] }}</p></div>
            @endif
        </div>

        @if(isset($weather))
        <div class="weather-data">
            <div class="feels"><p class="bold"><p>Feels Like</p>{{ $weather['feels_like'] }}°C</p></div>
            <div class="humidity"><p class="bold"><p>Humidity</p>{{ $weather['humidity'] }}%</p></div>
            <div class="wind"><p class="bold"><p>Wind Speed</p>{{ $weather['wind_speed'] }} MPH</p></div>
        </div>
        @endif

        <!-- Exchange Rate Table -->
        <div class="exchange-rate-table">
            <h4>Exchange Rates</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Currency</th>
                        <th>Rate (in PKR)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>USD</td>
                        <td id="usdRate">Loading...</td>
                    </tr>
                    <tr>
                        <td>EUR</td>
                        <td id="eurRate">Loading...</td>
                    </tr>
                    <tr>
                        <td>AED</td>
                        <td id="aedRate">Loading...</td>
                    </tr>
                    <tr>
                        <td>JPY</td>
                        <td id="jpyRate">Loading...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>




</div>
{{-- 
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const weatherData = @json($weather ?? null);  // Get weather data from Laravel backend
        const weatherApp = document.getElementById("weatherApp");

        if (weatherData && weatherData.name) {
            const cityName = weatherData.name;
            console.log("City Name:", cityName);

            // Fetch latitude and longitude using city name via OpenStreetMap Nominatim Geocoding API
            fetch(`https://nominatim.openstreetmap.org/search?q=${cityName}&format=json&limit=1`)
                .then(response => response.json())
                .then(locationData => {
                    if (locationData.length > 0) {
                        const latitude = locationData[0].lat;
                        const longitude = locationData[0].lon;

                        console.log("Latitude:", latitude);
                        console.log("Longitude:", longitude);

                        // Fetch country code using latitude and longitude from Geocoding API
                        fetch(`https://nominatim.openstreetmap.org/reverse?lat=${latitude}&lon=${longitude}&format=json`)
                            .then(response => response.json())
                            .then(locationData => {
                                console.log("Location data:", locationData);

                                const countryCode = locationData.address.country_code.toUpperCase();
                                console.log("Country code:", countryCode);

                                // Define currency based on the country
                                const currencyMap = {
                                    "PK": "PKR",  // Pakistan
                                    "IN": "INR",  // India
                                    "US": "USD",  // United States
                                    "GB": "GBP",  // United Kingdom
                                    "EU": "EUR",  // European Union
                                    "JP": "JPY",  // Japan
                                    "CN": "CNY",  // China
                                    "AU": "AUD",  // Australia
                                    "CA": "CAD",  // Canada
                                    "SA": "SAR",  // Saudi Arabia
                                    "AE": "AED",  // United Arab Emirates
                                    "SG": "SGD",  // Singapore
                                    "BD": "BDT",  // Bangladesh
                                    "MY": "MYR",  // Malaysia
                                    "TH": "THB",  // Thailand
                                    "ZA": "ZAR",  // South Africa
                                    "RU": "RUB",  // Russia
                                    "KR": "KRW",  // South Korea
                                    "CH": "CHF",  // Switzerland
                                    "SE": "SEK",  // Sweden
                                    "NO": "NOK",  // Norway
                                    "BR": "BRL",  // Brazil
                                    "MX": "MXN",  // Mexico
                                    "NZ": "NZD",  // New Zealand
                                    "ID": "IDR",  // Indonesia
                                    "HK": "HKD",  // Hong Kong
                                    "PH": "PHP",  // Philippines
                                    "EG": "EGP",  // Egypt
                                    "NG": "NGN",  // Nigeria
                                    "TR": "TRY",  // Turkey
                                };

                                const localCurrency = currencyMap[countryCode] || "USD";  // Fallback to USD if country not found
                                console.log("Local Currency:", localCurrency);

                                // Fetch exchange rate for USD to local currency
                                fetch(`https://api.exchangerate-api.com/v4/latest/USD`)
                                    .then(response => response.json())
                                    .then(data => {
                                        console.log("Exchange rate data:", data);

                                        // Get the required exchange rates
                                        const usdToPkr = data.rates["PKR"];
                                        const eurToPkr = usdToPkr / data.rates["EUR"]; // Euro to PKR
                                        const aedToPkr = usdToPkr / data.rates["AED"]; // Dirham to PKR
                                        const jpyToPkr = usdToPkr / data.rates["JPY"]; // Yen to PKR

                                        // Update the table cells with the fetched rates
                                        document.getElementById("usdRate").innerText = usdToPkr.toFixed(2);
                                        document.getElementById("eurRate").innerText = eurToPkr.toFixed(2);
                                        document.getElementById("aedRate").innerText = aedToPkr.toFixed(2);
                                        document.getElementById("jpyRate").innerText = jpyToPkr.toFixed(2);

                                        console.log(`1 USD = ${usdToPkr} PKR, 1 EUR = ${eurToPkr.toFixed(2)} PKR, 1 AED = ${aedToPkr.toFixed(2)} PKR, 1 JPY = ${jpyToPkr.toFixed(2)} PKR`);
                                    })
                                    .catch(error => {
                                        document.getElementById("usdRate").innerText = "Error";
                                        document.getElementById("eurRate").innerText = "Error";
                                        document.getElementById("aedRate").innerText = "Error";
                                        document.getElementById("jpyRate").innerText = "Error";
                                        console.error("Error fetching exchange rate:", error);
                                    });

                                // Change background based on weather description
                                const weatherBackgrounds = {
                                    'clear sky': 'url(/img/clear_sky.jpg)',
                                    'few clouds': 'url(/img/fewclouds.jpeg)',
                                    'scattered clouds': 'url(/img/scatteredclouds.jpg)',
                                    'broken clouds': 'url(/img/brokenclouds.jpg)',
                                    'light rain': 'url(/img/lightrain.jpg)',
                                    'moderate rain': 'url(/img/moderaterain.gif)',
                                    'heavy intensity rain': 'url(/img/heavyrain.jpg)',
                                    'thunderstorm': 'url(/img/thunderstorm.jpg)',
                                    'snow': 'url(/img/snow2.jpg)',
                                    'mist': 'url(/img/mist.jpg)',
                                    'fog': 'url(/img/fog.jpg)',
                                    'haze': 'url(/img/haze.webp)',
                                    'default': 'url(/img/default.jpg)' // Default background if no match is found
                                };

                                if (weatherData && weatherData.description) {
                                    const description = weatherData.description.toLowerCase();
                                    // Check if there's a background image for the current weather condition
                                    if (weatherBackgrounds[description]) {
                                        weatherApp.style.backgroundImage = weatherBackgrounds[description];
                                    } else {
                                        weatherApp.style.backgroundImage = weatherBackgrounds['default'];
                                    }
                                } else {
                                    weatherApp.style.backgroundImage = weatherBackgrounds['default'];
                                }

                            })
                            .catch(error => {
                                document.getElementById("exchangeRate").innerText = "Country data unavailable.";
                                console.error("Error fetching country data:", error);
                            });
                    } else {
                        console.error("No location data found for city:", cityName);
                    }
                })
                .catch(error => {
                    console.error("Error fetching location data:", error);
                });
        } else {
            document.getElementById("exchangeRate").innerText = "Weather data unavailable.";
            console.error("City name not found in weather data.");
        }

        // Auto-submit form on Enter press in the search bar
        const form = document.getElementById('searchForm');
        const input = document.getElementById('cityInput');
        input.addEventListener("keypress", function(event) {
            if (event.key === "Enter") {
                event.preventDefault(); 
                form.submit(); 
            }
        });
    });
</script> --}}

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const weatherApp = document.getElementById("weatherApp");

        function fetchExchangeRates() {
            // Fetch exchange rate for USD to local currency
            fetch(`https://api.exchangerate-api.com/v4/latest/USD`)
                .then(response => response.json())
                .then(data => {
                    console.log("Exchange rate data:", data);

                    // Get the required exchange rates
                    const usdToPkr = data.rates["PKR"];
                    const eurToPkr = usdToPkr / data.rates["EUR"]; // Euro to PKR
                    const aedToPkr = usdToPkr / data.rates["AED"]; // Dirham to PKR
                    const jpyToPkr = usdToPkr / data.rates["JPY"]; // Yen to PKR

                    // Update the table cells with the fetched rates
                    document.getElementById("usdRate").innerText = usdToPkr.toFixed(2);
                    document.getElementById("eurRate").innerText = eurToPkr.toFixed(2);
                    document.getElementById("aedRate").innerText = aedToPkr.toFixed(2);
                    document.getElementById("jpyRate").innerText = jpyToPkr.toFixed(2);

                    console.log(`1 USD = ${usdToPkr} PKR, 1 EUR = ${eurToPkr.toFixed(2)} PKR, 1 AED = ${aedToPkr.toFixed(2)} PKR, 1 JPY = ${jpyToPkr.toFixed(2)} PKR`);
                })
                .catch(error => {
                    document.getElementById("usdRate").innerText = "Error";
                    document.getElementById("eurRate").innerText = "Error";
                    document.getElementById("aedRate").innerText = "Error";
                    document.getElementById("jpyRate").innerText = "Error";
                    console.error("Error fetching exchange rate:", error);
                });
        }

        const weatherData = @json($weather ?? null);  // Get weather data from Laravel backend

        if (weatherData && weatherData.name) {
            const cityName = weatherData.name;
            console.log("City Name:", cityName);

            // Fetch latitude and longitude using city name via OpenStreetMap Nominatim Geocoding API
            fetch(`https://nominatim.openstreetmap.org/search?q=${cityName}&format=json&limit=1`)
                .then(response => response.json())
                .then(locationData => {
                    if (locationData.length > 0) {
                        const latitude = locationData[0].lat;
                        const longitude = locationData[0].lon;

                        console.log("Latitude:", latitude);
                        console.log("Longitude:", longitude);

                        // Fetch country code using latitude and longitude from Geocoding API
                        fetch(`https://nominatim.openstreetmap.org/reverse?lat=${latitude}&lon=${longitude}&format=json`)
                            .then(response => response.json())
                            .then(locationData => {
                                console.log("Location data:", locationData);

                                const countryCode = locationData.address.country_code.toUpperCase();
                                console.log("Country code:", countryCode);

                                // Define currency based on the country
                                const currencyMap = {
                                    "PK": "PKR",  // Pakistan
                                    "IN": "INR",  // India
                                    "US": "USD",  // United States
                                    "GB": "GBP",  // United Kingdom
                                    "EU": "EUR",  // European Union
                                    "JP": "JPY",  // Japan
                                    "CN": "CNY",  // China
                                    "AU": "AUD",  // Australia
                                    "CA": "CAD",  // Canada
                                    "SA": "SAR",  // Saudi Arabia
                                    "AE": "AED",  // United Arab Emirates
                                    "SG": "SGD",  // Singapore
                                    "BD": "BDT",  // Bangladesh
                                    "MY": "MYR",  // Malaysia
                                    "TH": "THB",  // Thailand
                                    "ZA": "ZAR",  // South Africa
                                    "RU": "RUB",  // Russia
                                    "KR": "KRW",  // South Korea
                                    "CH": "CHF",  // Switzerland
                                    "SE": "SEK",  // Sweden
                                    "NO": "NOK",  // Norway
                                    "BR": "BRL",  // Brazil
                                    "MX": "MXN",  // Mexico
                                    "NZ": "NZD",  // New Zealand
                                    "ID": "IDR",  // Indonesia
                                    "HK": "HKD",  // Hong Kong
                                    "PH": "PHP",  // Philippines
                                    "EG": "EGP",  // Egypt
                                    "NG": "NGN",  // Nigeria
                                    "TR": "TRY",  // Turkey
                                };

                                const localCurrency = currencyMap[countryCode] || "USD";  // Fallback to USD if country not found
                                console.log("Local Currency:", localCurrency);

                                // Fetch exchange rates for local currency
                                fetchExchangeRates(); // Fetch the exchange rates on weather change

                                // Change background based on weather description
                                const weatherBackgrounds = {
                                    'clear sky': 'url(/img/clear_sky.jpg)',
                                    'few clouds': 'url(/img/fewclouds.jpeg)',
                                    'scattered clouds': 'url(/img/scatteredclouds.jpg)',
                                    'broken clouds': 'url(/img/brokenclouds.jpg)',
                                    'light rain': 'url(/img/lightrain.jpg)',
                                    'moderate rain': 'url(/img/moderaterain.gif)',
                                    'heavy intensity rain': 'url(/img/heavyrain.jpg)',
                                    'thunderstorm': 'url(/img/thunderstorm.jpg)',
                                    'snow': 'url(/img/snow2.jpg)',
                                    'mist': 'url(/img/mist.jpg)',
                                    'fog': 'url(/img/fog.jpg)',
                                    'haze': 'url(/img/haze2.jpg)',
                                    'default': 'url(/img/default.jpg)' // Default background if no match is found
                                };

                                if (weatherData && weatherData.description) {
                                    const description = weatherData.description.toLowerCase();
                                    // Check if there's a background image for the current weather condition
                                    if (weatherBackgrounds[description]) {
                                        weatherApp.style.backgroundImage = weatherBackgrounds[description];
                                    } else {
                                        weatherApp.style.backgroundImage = weatherBackgrounds['default'];
                                    }
                                } else {
                                    weatherApp.style.backgroundImage = weatherBackgrounds['default'];
                                }

                            })
                            .catch(error => {
                                document.getElementById("exchangeRate").innerText = "Country data unavailable.";
                                console.error("Error fetching country data:", error);
                            });
                    } else {
                        console.error("No location data found for city:", cityName);
                    }
                })
                .catch(error => {
                    console.error("Error fetching location data:", error);
                });
        } else {
            document.getElementById("exchangeRate").innerText = "Weather data unavailable.";
            console.error("City name not found in weather data.");
        }

        // Auto-submit form on Enter press in the search bar
        const form = document.getElementById('searchForm');
        const input = document.getElementById('cityInput');
        input.addEventListener("keypress", function(event) {
            if (event.key === "Enter") {
                event.preventDefault(); 
                form.submit(); 
            }
        });
    });
</script>


@endsection
