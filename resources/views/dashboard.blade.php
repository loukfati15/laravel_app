
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Superuser Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
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

        .btn-custom {
            border-radius: 50px; /* Round the edges */
            font-size: 20px; /* Adjust font size */
            padding: 10px 30px; /* Adjust padding */
            margin: 0 70px;
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
            height: 400px !important;
        }
    </style>
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
    <div class="container text-center">
        <h3>Select Date Range</h3>
        <label for="start-date">Start Date:</label>
        <input type="date" id="start-date">
        <label for="end-date">End Date:</label>
        <input type="date" id="end-date">
    </div>

    <!-- Buttons and Notifications -->
    <div class="container text-center">
        <button class="btn btn-danger btn-custom" id="fetch-notifications">Notifications</button>
        <button class="btn btn-danger btn-custom" id="analyse-button">Analyse</button>
        <button class="btn btn-danger btn-custom" id="export-data">Export data</button>
        <button class="btn btn-danger btn-custom" id="export-report">Export report</button>
    </div>

    <div class="container text-center mt-4">
        <ul class="notification-list" id="notification-list"></ul>
    </div>

    <!-- Analysis Section -->
    <div class="analysis-section">
        <h3>Select Analysis Type</h3>
        <button class="btn btn-primary btn-custom" id="show-temperature">Temperature</button>
        <button class="btn btn-primary btn-custom" id="show-humidity">Humidity</button>
        <button class="btn btn-primary btn-custom" id="show-pressure">Pressure</button>
        <button class="btn btn-primary btn-custom" id="show-battery_life">battery_life</button>
        <button class="btn btn-primary btn-custom" id="show-battery_level">battery_level</button>
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

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.3/html2canvas.min.js"></script>


<script>
/*document.addEventListener('DOMContentLoaded', function () {
    function renderChart(chartId, label, labels, datasets) {
        const ctx = document.getElementById(chartId).getContext('2d');

        // Check if a previous chart instance exists and destroy it
        if (window[chartId] && typeof window[chartId].destroy === 'function') {
            window[chartId].destroy();
        }

        // Create a new chart instance and save it in the global window object
        window[chartId] = new Chart(ctx, {
            type: 'line', // 'line' can be changed to 'bar', 'pie', etc.
            data: {
                labels: labels, // The x-axis labels (e.g., dates)
                datasets: datasets // The data points grouped by region
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    },
                    y: {
                        display: true,
                        title: {
                            display: true,
                            text: label
                        },
                        beginAtZero: false
                    }
                }
            }
        });
    }

    // Event listener for the "Analyse" button
    document.getElementById('analyse-button').addEventListener('click', function () {
        const startDate = document.getElementById('start-date').value;
        const endDate = document.getElementById('end-date').value;

        if (!startDate || !endDate) {
            alert('Please select both start and end dates.');
            return;
        }

        fetch(`/regions/${superuserId}`)
            .then(response => response.json())
            .then(superuserRegions => {
                const regionIds = JSON.stringify(superuserRegions.map(region => region.id));

                fetch(`/module-data?region_ids=${encodeURIComponent(regionIds)}&start_date=${encodeURIComponent(startDate)}&end_date=${encodeURIComponent(endDate)}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log("Module data fetched", data);

                        // Show the analysis section
                        document.querySelector('.analysis-section').style.display = 'block';

                        // Assuming the default view is to show temperature
                        fetchAndDisplayData('temperature', data);
                    })
                    .catch(error => {
                        console.error('Error fetching module data:', error);
                        alert('Error fetching module data: ' + error.message);
                    });
            })
            .catch(error => {
                console.error('Error fetching superuser regions:', error);
                alert('Error fetching superuser regions: ' + error.message);
            });
    });

    // Event listeners for analysis buttons
    document.getElementById('show-temperature').addEventListener('click', function () {
        fetchAndDisplayData('temperature');
    });

    document.getElementById('show-humidity').addEventListener('click', function () {
        fetchAndDisplayData('humidity');
    });

    document.getElementById('show-pressure').addEventListener('click', function () {
        fetchAndDisplayData('pressure');
    });
    document.getElementById('show-battery_life').addEventListener('click', function () {
        fetchAndDisplayData('battery_life');
    });
    document.getElementById('show-battery_level').addEventListener('click', function () {
        fetchAndDisplayData('battery_level');
    });

    function fetchAndDisplayData(type, data = null) {
        const startDate = document.getElementById('start-date').value;
        const endDate = document.getElementById('end-date').value;

        if (!startDate || !endDate) {
            alert('Please select both start and end dates.');
            return;
        }

        const processAndDisplayData = (data) => {
            console.log("Data fetched", data);

            // Group data by region name
            const groupedData = {};
            data.forEach(entry => {
                if (!groupedData[entry.region_name]) {
                    groupedData[entry.region_name] = [];
                }
                groupedData[entry.region_name].push(entry);
            });

            // Prepare datasets
            const datasets = [];
            let colors = ['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)']; // Add more colors as needed
            let index = 0;

            for (const region in groupedData) {
                datasets.push({
                    label: region,
                    data: groupedData[region].map(d => d[type]),
                    borderColor: colors[index % colors.length],
                    backgroundColor: colors[index % colors.length].replace('1)', '0.2)'),
                    borderWidth: 1
                });
                index++;
            }

            const labels = groupedData[Object.keys(groupedData)[0]].map(d => d.date); // Assuming all regions have the same dates

            if (type === 'temperature') {
                showGraph('temperature-graph');
                renderChart('temperature-chart', 'Temperature', labels, datasets);
            } else if (type === 'humidity') {
                showGraph('humidity-graph');
                renderChart('humidity-chart', 'Humidity', labels, datasets);
            } else if (type === 'pressure') {
                showGraph('pressure-graph');
                renderChart('pressure-chart', 'Pressure', labels, datasets);
            } else if (type === 'battery_life') {
                showGraph('battery_life-graph');
                renderChart('battery_life-chart', 'Battery Life', labels, datasets);
            } else if (type === 'battery_level') {
                showGraph('battery_level-graph');
                renderChart('battery_level-chart', 'Battery Level', labels, datasets);
            }
        };

        if (data) {
            processAndDisplayData(data);
        } else {
            fetch(`/regions/${superuserId}`)
                .then(response => response.json())
                .then(superuserRegions => {
                    const regionIds = JSON.stringify(superuserRegions.map(region => region.id));

                    fetch(`/module-data?region_ids=${encodeURIComponent(regionIds)}&start_date=${encodeURIComponent(startDate)}&end_date=${encodeURIComponent(endDate)}`)
                        .then(response => response.json())
                        .then(processAndDisplayData)
                        .catch(error => {
                            console.error('Error fetching module data:', error);
                            alert('Error fetching module data: ' + error.message);
                        });
                })
                .catch(error => {
                    console.error('Error fetching superuser regions:', error);
                    alert('Error fetching superuser regions: ' + error.message);
                });
        }
    }

    function showGraph(graphId) {
        // Hide all graphs
        document.querySelectorAll('.graph-container').forEach(container => {
            container.style.display = 'none';
        });

        // Show the selected graph
        document.getElementById(graphId).style.display = 'block';
    }

    // Export data on button click
    document.getElementById('export-data').addEventListener('click', function () {
        let csvContent = "data:text/csv;charset=utf-8,";
        csvContent += "Type,Values\n";

        // Add graph data to CSV
        graphData.forEach(graph => {
            csvContent += graph.type + ',' + graph.data.join(',') + "\n";
        });

        // Add a blank line
        csvContent += "\n";

        // Add notification data to CSV
        csvContent += "Type,Description,Date\n";
        notificationsData.forEach(notification => {
            csvContent += `${notification.Type},${notification.Description},${notification.date}\n`;
        });

        // Create a link to download the CSV file
        const encodedUri = encodeURI(csvContent);
        const link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "dashboard_data.csv");
        document.body.appendChild(link); // Required for Firefox

        // Click the link to download the file
        link.click();
    });

    // Export report on button click
    document.getElementById('export-report').addEventListener('click', function () {
        const doc = new jspdf.jsPDF(); // Initialize jsPDF

        // Add the title
        doc.setFontSize(18);
        doc.text('Dashboard Report', 14, 22);

        // Capture graphs and add them to PDF
        const graphs = document.querySelectorAll('.graph-class'); // Adjust the selector to match your graphs
        let currentY = 30; // Position for the next graph/image in PDF

        graphs.forEach((graph, index) => {
            html2canvas(graph).then(canvas => {
                const imgData = canvas.toDataURL('image/png');
                doc.addImage(imgData, 'PNG', 10, currentY, 190, 90); // Adjust position and size
                currentY += 100; // Space between images
                if (index === graphs.length - 1) {
                    // After adding all graphs, add notifications
                    addNotificationsToPDF(doc, currentY);
                }
            });
        });

        function addNotificationsToPDF(doc, startY) {
            doc.setFontSize(12);
            doc.text('Notifications', 14, startY + 10);

            let currentY = startY + 20;
            notificationsData.forEach(notification => {
                doc.text(`Type: ${notification.Type}`, 14, currentY);
                doc.text(`Description: ${notification.Description}`, 14, currentY + 10);
                doc.text(`Date: ${notification.date}`, 14, currentY + 20);
                currentY += 30;
                if (currentY > 270) {
                    doc.addPage();
                    currentY = 20;
                }
            });

            doc.save('dashboard_report.pdf'); // Save the PDF file
        }
    });
});*/



</script>

</body>
<footer>
  <div class="footer-content">
    <div class="footer-section about">
      <h2>Your Company</h2>
      <p>Providing quality products and services since 2024.</p>
    </div>
    <div class="footer-section links">
      <h3>Quick Links</h3>
      <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#">About Us</a></li>
        <li><a href="#">Services</a></li>
        <li><a href="#">Contact</a></li>
      </ul>
    </div>
    <div class="footer-section contact">
      <h3>Contact Us</h3>
      <p>Email: contact@yourcompany.com</p>
      <p>Phone: (123) 456-7890</p>
    </div>
    <div class="footer-section social-media">
      <h3>Follow Us</h3>
      <a href="#" class="social-icon">Facebook</a>
      <a href="#" class="social-icon">Twitter</a>
      <a href="#" class="social-icon">Instagram</a>
    </div>
  </div>
  <div class="footer-bottom">
    <p>&copy; 2024 Your Company. All rights reserved.</p>
  </div>
</footer>

</html>
