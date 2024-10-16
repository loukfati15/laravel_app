
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Superuser Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .btn-custom:hover {
         background-color: lightgreen;
         color : darck ;
          /* Couleur plus sombre pour l'effet de survol */
         }
        .btn-custom {
            border-radius: 50px; /* Round the edges */
            font-size: 20px; /* Adjust font size */
            padding: 10px 30px; /* Adjust padding */
            margin: 0 70px;
            
        }
        
        footer {
        background-color: #333;
        color: #fff;
        padding: 20px 0;
        position: relative;
        bottom: 0;
        width: 100%;
        font-family: Arial, sans-serif;
        }

        .footer-content {
        display: flex;
        justify-content: space-between;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
        }

        .footer-section {
        flex: 1;
        margin: 0 10px;
        }

        .footer-section h2, .footer-section h3 {
        margin-top: 0;
        }

        .footer-section a {
        color: #fff;
        text-decoration: none;
        }

        .footer-section a:hover {
        text-decoration: underline;
        }

        .footer-section ul {
        list-style-type: none;
        padding: 0;
        }

        .footer-section ul li {
        margin: 5px 0;
        }

        .social-icon {
        margin-right: 10px;
        }

        .footer-bottom {
        text-align: center;
        margin-top: 20px;
        }

        .footer-bottom p {
        margin: 0;
        }

        .notification-list {
            list-style-type: none; /* Remove default bullets */
            padding: 0;
        }
        .notification-list li {
            border: 1px solid #ddd; /* Light grey border */
            background-color: #f8f9fa; /* Light grey background */
            margin-bottom: 10px; /* Space between items */
            padding: 10px; /* Padding inside items */
            border-radius: 5px; /* Rounded corners */
        }
        .analysis-section,
        .graph-container {
            display: none;
        }
        canvas {
            width: 100% !important;
            height: 300px !important;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.3/html2canvas.min.js"></script>

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
                        // Pass the current superuser ID to JavaScript
                        const superuserId = {{ auth()->user()->id }};
                    </script>
                    <script src="{{ asset('js/dashboard.js') }}"></script>

                    <!-- Region List Container -->
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
        <button class="btn btn-custom" id="export-data" style="background-color: green; color: white;">Export data</button>
        <button class="btn btn-custom" id="export-report" style="background-color: green; color: white;">Export report</button>
    </div>

    <div class="container text-center mt-4">
        <ul class="notification-list" id="notification-list"></ul>
    </div>

    <!-- Analysis Section -->
    <div class="analysis-section">
        <h3>Select Analysis Type</h3>
        <button class="btn btn-primary btn-custom" style="background-color: grey; color: white;" id="show-temperature">Temperature</button>
        <button class="btn btn-primary btn-custom" style="background-color: grey; color: white;" id="show-humidity">Humidity</button>
        <button class="btn btn-primary btn-custom" style="background-color: grey; color: white;" id="show-pressure">Pressure</button>
        <button class="btn btn-primary btn-custom" style="background-color: grey; color: white;" id="show-battery_life">battery_life</button>
        <button class="btn btn-primary btn-custom" style="background-color: grey; color: white;" id="show-battery_level">battery_level</button>
    </div>

    <!-- Graph Containers -->
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

    @endsection
</x-app-layout>



<script>

document.getElementById('export-report').addEventListener('click', function () {
    exportReport();
});

function exportReport() {
    const doc = new jspdf.jsPDF();

    // Add a cover page
    doc.setFontSize(30);
    doc.text('Dashboard Report', 105, 50, null, null, 'center');
    doc.setFontSize(16);
    doc.text('Generated on: ' + new Date().toLocaleString(), 105, 70, null, null, 'center');
    doc.addPage();

    // Function to add graphs to PDF
    function addGraphsToPDF(callback) {
        const graphContainers = document.querySelectorAll('.graph-container');
        let graphIndex = 0;

        function addNextGraph() {
            if (graphIndex < graphContainers.length) {
                const graph = graphContainers[graphIndex];
                // Temporarily force the graph to be visible
                const originalDisplay = graph.style.display;
                graph.style.display = 'block';
                html2canvas(graph).then(canvas => {
                    const imgData = canvas.toDataURL('image/png');
                    doc.addImage(imgData, 'PNG', 10, 20, 190, 100); // Adjust the position and size as needed
                    if (graphIndex < graphContainers.length - 1) {
                        doc.addPage();
                    }
                    graph.style.display = originalDisplay; // Revert to the original display setting
                    graphIndex++;
                    addNextGraph();
                });
            } else {
                callback(); // Continue to add notifications after all graphs are added
            }
        }

        addNextGraph();
    }

    // Function to add notifications to PDF
    function addNotificationsToPDF() {
        doc.addPage();
        doc.setFontSize(20);
        doc.text('Notifications', 105, 20, null, null, 'center');
        doc.setFontSize(12);

        const notificationList = document.getElementById('notification-list');
        const notifications = notificationList.getElementsByTagName('li');
        let lineHeight = 30;

        Array.from(notifications).forEach((notification, index) => {
            if (lineHeight > 280) {
                doc.addPage();
                lineHeight = 20;
            }
            doc.text(notification.textContent, 10, lineHeight);
            lineHeight += 10;
        });

        doc.save('Dashboard_Report.pdf');
    }

    // Generate and export the PDF
    addGraphsToPDF(addNotificationsToPDF);
}



</script>

</body>
<footer class="mt-5">
    <div class="footer-content">
        <div class="footer-section about">
            <h2 class="color">RevoFeed</h2>
            <p>RevoFeed is a pioneering Moroccan biotechnology company established in 2019.</p></div>
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
