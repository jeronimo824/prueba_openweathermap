<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                    
                </header>
                
            @endisset

            <!-- Page Content -->
            <main>
                   <a class="navbar-brand" href="{{ url('/posts')}}">
                        Posts
</a>     
                <div class="container">
        <h1>Como anda el clima</h1>
            <div class="input-group">
                <input 
                type="text"
                id="cityInput"
                placeholder="Nombre de la ciudad (Ej .Buenos aires)">
            
                <input type="text"
                id="countryInput"
                placeholder="Codigo del pais(Ej. Col - Opcional)">
            </div>
            <button id="getWeatherBtn">Obtener clima</button>
            <div id="weather-info">

            </div>
            </div>
            <script>
            const API_KEY = "9e8d071c21485460bebc73c3b2d54f58";
            const cityInput = document.getElementById("cityInput");
            const countryInput = document.getElementById("countryInput");
            const getWeatherBtn = document.getElementById("getWeatherBtn");
            const weatherInfoDiv = document.querySelector("#weather-info");

            getWeatherBtn.addEventListener("click", () =>{
                const city = cityInput.value;
                const country = countryInput.value;

                if(city.trim() === ""){
                    alert("Por favor, ingresa el nombre de una ciudad");
                    return;
                }


                const API_URL = `https://api.openweathermap.org/data/2.5/weather?q=${city},${country}&appid=${API_KEY}&units=metric&lang=es`
            
                fetch(API_URL)
                .then((response) => {
                    if(!response.ok){
                        throw new Error(
                            `Error ${response.status}: Ciudad no encontrada.`
                        )
                    }
                    return response.json();
                })
                .then((data) => {
                    displayWeather(data);
                })
                .catch((error) => {
                    weatherInfoDiv.innerHTML = `<p style="color: red;">${error.message}</p>`
                })
            
            })
            function displayWeather(data){
                const cityName = data.name;
                const temp = data.main.temp;
                const description = data.weather[0].description;
                const humidity = data.main.humidity;
                const windSpeed = data.wind.speed;

                weatherInfoDiv.innerHTML = `<h2>Clima en ${cityName}</h2>
                <p><strong>Temperatura:</strong>${temp}C</p>
                <p><strong>Description:</strong>${description}C</p>
                <p><strong>Humedad:</strong>${humidity}C</p>
                <p><strong>Velocidad:</strong>${windSpeed}C</p>`
            }
            </script>
            </main>
        </div>
    </body>
</html>
