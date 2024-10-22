<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Superuser Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/SupeDash.css') }}">
 <style></style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.3/html2canvas.min.js"></script>
</head>
<body>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Superuser Dashboard') }}
        </h2>
    </x-slot>

    @section('content')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Map Container -->
                    <div id="map" style="height: 300px;"></div>
                    <script>
                        const superuserId = {{ auth()->user()->id }};
                    </script>
                    <script src="{{ asset('js/dashboard.js') }}"></script>
                    <ul id="region-list" class="mt-4"></ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Date Range Picker -->
    <div class="container text-center mb-5">
        <h3>Select Date Range</h3>
        <label for="start-date">Start Date:</label>
        <input type="date" id="start-date">
        <label for="end-date">End Date:</label>
        <input type="date" id="end-date">
    </div>

    <!-- Buttons and Notifications -->
    <div class="container text-center mb-5">
        <button class="btn btn-custom" id="fetch-notifications" style="background-color: green; color: white;">Notifications</button>
        <button class="btn btn-custom" id="analyse-button" style="background-color: green; color: white;">Analyse</button>
        <button class="btn btn-custom" id="export-data" style="background-color: green; color: white;">Export data (CSV)</button>
        <button class="btn btn-custom" id="export-report" style="background-color: green; color: white;">Export report (PDF)</button>
    </div>

    <div class="container text-center mt-4">
        <ul class="notification-list" id="notification-list"></ul>
    </div>

    <!-- Analysis Section -->
    <div class="analysis-section">
        <h3>Select Analysis Type</h3>
        <select class="form-control" id="analysis-type">
            <option value="temperature">Temperature</option>
            <option value="humidity">Humidity</option>
            <option value="pressure">Pressure</option>
            <option value="battery_life">Battery Life</option>
            <option value="battery_level">Battery Level</option>
        </select>
    </div>

    <!-- Graph Containers -->
     <div class="container text-center mt-4">
    <div class="graph-container" id="temperature-graph">
        <h3>Graphique de la Température</h3>
        <canvas id="temperature-chart"></canvas> 
        <canvas id="temperature-normal-chart"></canvas>
        <div id="temperature-stats"></div>
    </div>

    <div class="graph-container" id="humidity-graph">
        <h3>Graphique de l'Humidité</h3>
        <canvas id="humidity-chart"></canvas> 
        <canvas id="humidity-normal-chart"></canvas>
        <div id="humidity-stats"></div>
    </div>

    <div class="graph-container" id="pressure-graph">
        <h3>Graphique de la Pression</h3>
        <canvas id="pressure-chart"></canvas> 
        <canvas id="pressure-normal-chart"></canvas>
        <div id="pressure-stats"></div>
    </div>

    <div class="graph-container" id="battery_level-graph">
        <h3>Graphique du Niveau de Batterie</h3>
        <canvas id="battery_level-chart"></canvas> 
        <canvas id="battery_level-normal-chart"></canvas>
        <div id="battery_level-stats"></div>
    </div>

    <div class="graph-container" id="battery_life-graph">
        <h3>Graphique de la Durée de Vie de la Batterie</h3>
        <canvas id="battery_life-chart"></canvas> 
        <canvas id="battery_life-normal-chart"></canvas>
        <div id="battery_life-stats"></div>
    </div>
    </div>
    @endsection
</x-app-layout>


<script src="{{ asset('js/jsnotic.js') }}"></script>


</body>
<footer class="mt-5">
    <div class="footer-content">
        <div class="footer-section about">
            <h2 class="color">RevoFeed</h2>
            <p>RevoFeed is a pioneering Moroccan biotechnology company established in 2019.</p>
        </div>
        <div class="footer-section links">
            <h3 class="color">Quick Links</h3>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Our Solutions</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </div>
        <div class="footer-section contact">
            <h3>Contact Us</h3>
            <p>Email: contact@revofeed.com</p>
            <p>Phone: (123) 456-7890</p>
        </div>
        <div class="footer-section social-media">
            <h3 class="color">Follow Us</h3>
            <a href="#" class="social-icon">Facebook</a>
            <a href="#" class="social-icon">Twitter</a>
            <a href="#" class="social-icon">Instagram</a>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2024 RevoFeed. All rights reserved.</p>
    </div>
</footer>
</html>
