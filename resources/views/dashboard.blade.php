{{-- @extends('layout')

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
                    <a class="nav-link text-white" href="{{ route('currency')}}">Currency exchange</a>
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
    <h2 class="heading">Weather Forecast & Local Currency Rates</h2>
    <div class="container">

        <!-- Search Bar for Weather -->
        <div class="search-bar">
            <form method="POST" action="{{ route('search') }}" id="searchForm">
                @csrf
                <input
                    type="text"
                    name="city"
                    id="cityInput"
                    placeholder="Enter city..."
                    style="color: white"
                    value="{{ old('city') }}"
                    required
                />
            </form>
        </div>

        <!-- Display Current Exchange Rate -->
        <div class="currency-exchange-info">
            <h4>Exchange Rate</h4>
            <p id="exchangeRate">Loading exchange rate...</p>
        </div>

        <!-- Weather Data Display -->
        <div class="top">
            @if(isset($weather))
                <div class="location"><p>{{ $weather['name'] }}</p></div>
                <div class="temperature">
                    <h1>{{ $weather['temperature'] }}°C</h1>
                </div>
                <div class="description">
                    <p>{{ $weather['description'] }}</p>
                </div>
            @endif
        </div>

        @if(isset($weather))
            <div class="bottom">
                <div class="feels">
                    <p class="bold">{{ $weather['feels_like'] }}°C</p>
                    <p>Feels Like</p>
                </div>
                <div class="humidity">
                    <p class="bold">{{ $weather['humidity'] }}%</p>
                    <p>Humidity</p>
                </div>
                <div class="wind">
                    <p class="bold">{{ $weather['wind_speed'] }} MPH</p>
                    <p>Wind Speed</p>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Script to Fetch Currency Rate Based on Country from OpenWeather Response -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const weatherData = @json($weather ?? null); // Get weather data from Laravel backend
        const weatherApp = document.getElementById("weatherApp");

        // Map weather descriptions to corresponding background images
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
            'haze': 'url(/img/haze.webp)'
        };

        // Set background image based on weather description
        if (weatherData && weatherBackgrounds[weatherData.description.toLowerCase()]) {
            weatherApp.style.backgroundImage = weatherBackgrounds[weatherData.description.toLowerCase()];
        } else {
            weatherApp.style.backgroundImage = 'url(/img/default.jpg)';
        }

        // Fetch country from weather data and display exchange rate
        // Fetch country from weather data and display exchange rate
        if (weatherData) {
        const countryCode = weatherData.sys.country;  // Ensure this accesses the correct country code
        // Define currency based on the country
        const currencyMap = {
        "PK": "PKR",  // Pakistan
        "IN": "INR",  // India
        "US": "USD",  // United States
        "GB": "GBP",  // United Kingdom
        "EU": "EUR",  // European Union
        // Add more country codes and currencies as needed
        };

        const localCurrency = currencyMap[countryCode] || "USD";  // Fallback to USD if country not found

        // Fetch exchange rate for USD to local currency
        fetch(`https://api.exchangerate-api.com/v4/latest/USD`)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                const exchangeRate = data.rates[localCurrency]; // Ensure you're accessing the correct rate
                document.getElementById("exchangeRate").innerText = `1 USD = ${exchangeRate} ${localCurrency}`;
            })
            .catch(error => {
                document.getElementById("exchangeRate").innerText = "Exchange rate not available.";
            });
        } else {
            document.getElementById("exchangeRate").innerText = "Weather data unavailable.";
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

@endsection --}}


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
                    <a class="nav-link text-white" href="{{ route('currency')}}">Currency exchange</a>
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
    <h2 class="heading">Weather Forecast & Local Currency Rates</h2>
    <div class="container">

        <!-- Search Bar for Weather -->
        <div class="search-bar">
            <form method="POST" action="{{ route('search') }}" id="searchForm">
                @csrf
                <input
                    type="text"
                    name="city"
                    id="cityInput"
                    placeholder="Enter city..."
                    style="color: white"
                    value="{{ old('city') }}"
                    required
                />
            </form>
        </div>

        <!-- Display Current Exchange Rate -->
        <div class="currency-exchange-info">
            <h4>Exchange Rate</h4>
            <p id="exchangeRate">Loading exchange rate...</p>
        </div>

        <!-- Weather Data Display -->
        <div class="top">
            @if(isset($weather))
                <div class="location"><p>{{ $weather['name'] }}</p></div>
                <div class="temperature">
                    <h1>{{ $weather['temperature'] }}°C</h1>
                </div>
                <div class="description">
                    <p>{{ $weather['description'] }}</p>
                </div>
            @endif
        </div>

        @if(isset($weather))
            <div class="bottom">
                <div class="feels">
                    <p class="bold">{{ $weather['feels_like'] }}°C</p>
                    <p>Feels Like</p>
                </div>
                <div class="humidity">
                    <p class="bold">{{ $weather['humidity'] }}%</p>
                    <p>Humidity</p>
                </div>
                <div class="wind">
                    <p class="bold">{{ $weather['wind_speed'] }} MPH</p>
                    <p>Wind Speed</p>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Script to Fetch Currency Rate Based on Country from OpenWeather Response -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const weatherData = @json($weather ?? null); // Get weather data from Laravel backend
        const weatherApp = document.getElementById("weatherApp");

        // Map weather descriptions to corresponding background images
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
            'haze': 'url(/img/haze.webp)'
        };

        // Set background image based on weather description
        if (weatherData && weatherBackgrounds[weatherData.description.toLowerCase()]) {
            weatherApp.style.backgroundImage = weatherBackgrounds[weatherData.description.toLowerCase()];
        } else {
            weatherApp.style.backgroundImage = 'url(/img/default.jpg)';
        }

        // Fetch country from weather data and display exchange rate
        if (weatherData) {
            const countryCode = weatherData.sys.country;  // Ensure this accesses the correct country code
            // Define currency based on the country
            const currencyMap = {
                "PK": "PKR",  // Pakistan
                "IN": "INR",  // India
                "US": "USD",  // United States
                "GB": "GBP",  // United Kingdom
                "EU": "EUR",  // European Union
                // Add more country codes and currencies as needed
            };

            const localCurrency = currencyMap[countryCode] || "USD";  // Fallback to USD if country not found

            // Fetch exchange rate for USD to local currency
            fetch(`https://api.exchangerate-api.com/v4/latest/USD`)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    const exchangeRate = data.rates[localCurrency]; // Ensure you're accessing the correct rate
                    document.getElementById("exchangeRate").innerText = `1 USD = ${exchangeRate} ${localCurrency}`;
                })
                .catch(error => {
                    document.getElementById("exchangeRate").innerText = "Exchange rate not available.";
                });
        } else {
            document.getElementById("exchangeRate").innerText = "Weather data unavailable.";
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

