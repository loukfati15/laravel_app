document.addEventListener('DOMContentLoaded', function () {
    console.log("DOM fully loaded and parsed");

    // Initialize the map centered on Morocco
    var map = L.map('map').setView([31.7917, -7.0926], 3.9);
    console.log("Map initialized");

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
    console.log("Tile layer added");

    // Fetch data from the gateway table
    fetch('/gateway-data')
        .then(response => response.json())
        .then(data => {
            console.log("Gateway data fetched", data);
            data.forEach(gateway => {
                if (gateway.latitude && gateway.longitude) {
                    var marker = L.circleMarker([gateway.latitude, gateway.longitude], {
                        radius: 3,
                        fillColor: "#ff7800",
                        color: "#000",
                        weight: 1,
                        opacity: 1,
                        fillOpacity: 0.8
                    }).addTo(map);
                }
            });
        })
        .catch(error => console.error('Error fetching gateway data:', error));

    // Ensure superuserId is defined
    if (typeof superuserId === 'undefined') {
        console.error("superuserId is not defined.");
        return;
    }

    // Variable to store selected region IDs
    let selectedRegionIds = [];

    // Fetch regions chosen by the superuser
    fetch(`/regions/${superuserId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(superuserRegions => {
            console.log("Superuser regions fetched", superuserRegions);
            const superuserRegionIds = superuserRegions.map(region => region.id);
            console.log("Superuser region IDs: ", superuserRegionIds);

            // Fetch all regions
            fetch('/regions')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log("All regions fetched", data);
                    data.forEach(region => {
                        var regionGeom = JSON.parse(region.geom);
                        console.log(`Processing region: ${region.region_name}, ID: ${region.id}`);
                        if (!region.id) {
                            console.error(`Region ${region.region_name} does not have a valid ID.`);
                            return;
                        }
                        var isSuperuserRegion = superuserRegionIds.includes(region.id);
                        console.log(`Region ${region.id} (${region.region_name}) is superuser region: ${isSuperuserRegion}`);
                        var color = isSuperuserRegion ? 'green' : 'grey';
                        console.log(`Color for region ${region.region_name}: ${color}`);

                        var polygon = L.geoJSON(regionGeom, {
                            style: function () {
                                return { color: color, weight: 2, opacity: 1, fillOpacity: 0.5 };
                            }
                        }).addTo(map);

                        console.log(`Added region ${region.region_name} with color ${color}`);

                        polygon.bindPopup(`<strong>${region.region_name}</strong><br>Gateways Number: ${region.gateway_count}`);

                        polygon.on('dblclick', function () {
                            addRegionToList(region.region_name, region.id);
                            // Add the region ID to the selectedRegionIds array
                            if (!selectedRegionIds.includes(region.id)) {
                                selectedRegionIds.push(region.id);
                            }
                        });
                    });
                })
                .catch(error => console.error('Error fetching all regions data:', error));
        })
        .catch(error => console.error('Error fetching superuser regions:', error));

    // Function to add region name to the list
    function addRegionToList(regionName, regionId) {
        const list = document.getElementById('region-list');
        const listItems = list.getElementsByTagName('li');
        let exists = false;

        for (let i = 0; i < listItems.length; i++) {
            if (listItems[i].firstChild.textContent === regionName) {
                exists = true;
                break;
            }
        }

        if (!exists) {
            const listItem = document.createElement('li');
            listItem.dataset.regionId = regionId; // Store the region ID in the list item
            const regionSpan = document.createElement('span');
            regionSpan.textContent = regionName;

            const deleteButton = document.createElement('button');
            deleteButton.textContent = 'X';
            deleteButton.style.width = '20px';
            deleteButton.style.height = '20px';
            deleteButton.style.borderRadius = '40%';
            deleteButton.style.backgroundColor = '#ff4d4d';
            deleteButton.style.color = 'white';
            deleteButton.style.cursor = 'pointer';
            deleteButton.style.marginLeft = '10px';
            deleteButton.style.textAlign = 'center';
            deleteButton.style.lineHeight = '20px';

            deleteButton.addEventListener('click', function () {
                // Remove the region ID from selectedRegionIds when deleted
                selectedRegionIds = selectedRegionIds.filter(id => id !== regionId);
                list.removeChild(listItem);

                // Remove notifications related to this region
                removeRegionNotifications(regionId);
            });

            listItem.appendChild(regionSpan);
            listItem.appendChild(deleteButton);
            list.appendChild(listItem);
        }
    }

    // Function to remove notifications of a specific region
    function removeRegionNotifications(regionId) {
        const notificationList = document.getElementById('notification-list');
        const notifications = notificationList.querySelectorAll(`[data-region-id="${regionId}"]`);
        notifications.forEach(notification => notification.remove());
    }

    // Fetch and display notifications for selected regions
    function fetchRegionNotifications() {
        const startDate = document.getElementById('start-date').value;
        const endDate = document.getElementById('end-date').value;

        if (!startDate || !endDate) {
            alert('Please select both start and end dates.');
            return;
        }

        const regionIds = JSON.stringify(selectedRegionIds);

        fetch(`/notifications?region_ids=${encodeURIComponent(regionIds)}&start_date=${encodeURIComponent(startDate)}&end_date=${encodeURIComponent(endDate)}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(notificationsGrouped => {
                console.log("Notifications fetched:", notificationsGrouped);
                displayNotifications(notificationsGrouped);
            })
            .catch(error => {
                console.error('Error fetching notifications:', error);
                alert('Error fetching notifications: ' + error.message);
            });
    }

    // Display notifications grouped by type
    function displayNotifications(notificationsGrouped) {
        const notificationList = document.getElementById('notification-list');
        notificationList.innerHTML = ''; // Clear previous notifications

        if (Object.keys(notificationsGrouped).length === 0) {
            notificationList.innerHTML = '<li>No notifications available for the selected period.</li>';
            return;
        }

        Object.keys(notificationsGrouped).forEach(regionId => {
            const regionNotifications = notificationsGrouped[regionId];

            // Group notifications by type
            const notificationsByType = {};
            regionNotifications.forEach(notification => {
                const type = notification.Type;
                if (!notificationsByType[type]) {
                    notificationsByType[type] = [];
                }
                notificationsByType[type].push(notification);
            });

            // Display notifications grouped by type
            Object.keys(notificationsByType).forEach(type => {
                const typeSection = document.createElement('li');
                typeSection.innerHTML = `<strong>${type}</strong>`;
                notificationList.appendChild(typeSection);

                const typeList = document.createElement('ul');
                notificationsByType[type].forEach(notification => {
                    const listItem = document.createElement('li');
                    listItem.dataset.regionId = regionId;
                    listItem.textContent = `Description: ${notification.Description}, Date: ${notification.date}`;
                    typeList.appendChild(listItem);
                });
                notificationList.appendChild(typeList);
            });
        });

        document.querySelector('.analysis-section').style.display = 'none'; // Hide graphs
        notificationList.style.display = 'block'; // Show notifications
    }

    // Handle "Analyse" button click
    document.getElementById('analyse-button').addEventListener('click', function () {
        const startDate = document.getElementById('start-date').value;
        const endDate = document.getElementById('end-date').value;

        if (!startDate || !endDate) {
            alert('Please select both start and end dates.');
            return;
        }

        if (selectedRegionIds.length === 0) {
            alert('Please select at least one region by double-clicking.');
            return;
        }

        const regionIds = JSON.stringify(selectedRegionIds);

        fetch(`/module-data?region_ids=${encodeURIComponent(regionIds)}&start_date=${encodeURIComponent(startDate)}&end_date=${encodeURIComponent(endDate)}`)
            .then(response => response.json())
            .then(data => {
                console.log("Module data fetched", data);

                if (!data.length) {
                    alert("No data available for the selected regions and date range.");
                    return;
                }

                // Hide notifications when displaying graphs
                document.getElementById('notification-list').style.display = 'none';
                document.querySelector('.analysis-section').style.display = 'block';

                // Initially, hide all graphs
                hideAllGraphs();

                // Show the default graph (Temperature)
                fetchAndDisplayData('temperature', data);
            })
            .catch(error => {
                console.error('Error fetching module data:', error);
                alert('Error fetching module data: ' + error.message);
            });
    });

    // Event listener for Notifications button
    document.getElementById('fetch-notifications').addEventListener('click', function () {
        if (selectedRegionIds.length === 0) {
            alert('Please select at least one region by double-clicking.');
            return;
        }

        hideAllGraphs();
        fetchRegionNotifications();
        document.querySelector('.analysis-section').style.display = 'none'; // Hide graphs
    });

    // Event listener for the dropdown selection
    document.getElementById('analysis-type').addEventListener('change', function () {
        const selectedValue = this.value;
        fetchAndDisplayData(selectedValue);
    });

    // Fetch and display data based on the selected type (temperature, humidity, etc.)
    function fetchAndDisplayData(type, data = null) {
        const startDate = document.getElementById('start-date').value;
        const endDate = document.getElementById('end-date').value;

        if (!startDate || !endDate) {
            alert('Please select both start and end dates.');
            return;
        }

        if (selectedRegionIds.length === 0) {
            alert('Please select at least one region by double-clicking.');
            return;
        }

        const processAndDisplayData = (data) => {
            console.log("Data fetched", data);

            const groupedData = {};
            data.forEach(entry => {
                if (!groupedData[entry.region_name]) {
                    groupedData[entry.region_name] = [];
                }
                entry[type] = parseFloat(entry[type]); // Ensure numbers are parsed
                groupedData[entry.region_name].push(entry);
            });

            const datasets = [];
            let colors = ['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)'];
            let index = 0;

            for (const region in groupedData) {
                const values = groupedData[region].map(d => d[type]);

                // Calculate and display statistics
                const stats = calculateStatistics(values);
                displayStatistics(type, stats);

                datasets.push({
                    label: region,
                    data: values,
                    borderColor: colors[index % colors.length],
                    backgroundColor: colors[index % colors.length].replace('1)', '0.2)'),
                    borderWidth: 1
                });
                index++;
            }

            const labels = groupedData[Object.keys(groupedData)[0]].map(d => d.date);

            showGraph(`${type}-graph`);
            renderChart(`${type}-chart`, type, labels, datasets);

            // Render the normal distribution for all regions
            renderNormalDistributionChart(`${type}-normal-chart`, type, groupedData);
        };

        if (data) {
            processAndDisplayData(data);
        } else {
            fetch(`/module-data?region_ids=${encodeURIComponent(JSON.stringify(selectedRegionIds))}&start_date=${encodeURIComponent(startDate)}&end_date=${encodeURIComponent(endDate)}`)
                .then(response => response.json())
                .then(processAndDisplayData)
                .catch(error => {
                    console.error('Error fetching module data:', error);
                    alert('Error fetching module data: ' + error.message);
                });
        }
    }

    function hideAllGraphs() {
        document.querySelectorAll('.graph-container').forEach(container => {
            container.style.display = 'none';
        });
    }

    function showGraph(graphId) {
        hideAllGraphs();
        document.getElementById(graphId).style.display = 'block';
    }

    function renderChart(chartId, label, labels, datasets) {
        const ctx = document.getElementById(chartId).getContext('2d');

        if (window[chartId] && typeof window[chartId].destroy === 'function') {
            window[chartId].destroy();
        }

        window[chartId] = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: datasets
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

    // Function to calculate statistics
    function calculateStatistics(data) {
        const n = data.length;
        const mean = data.reduce((a, b) => a + b, 0) / n;
        const sortedData = data.slice().sort((a, b) => a - b);
        const median = (n % 2 === 0) ? (sortedData[n / 2 - 1] + sortedData[n / 2]) / 2 : sortedData[Math.floor(n / 2)];
        const variance = data.reduce((a, b) => a + Math.pow(b - mean, 2), 0) / n;
        const stdDeviation = Math.sqrt(variance);

        return {
            mean,
            median,
            variance,
            stdDeviation
        };
    }

    // Function to display statistics
    function displayStatistics(type, stats) {
        const statsContainer = document.getElementById(`${type}-stats`);
        statsContainer.innerHTML = `
            <p><strong>Statistics for ${type}:</strong></p>
            <ul>
                <li>Mean: ${stats.mean.toFixed(2)}</li>
                <li>Median: ${stats.median.toFixed(2)}</li>
                <li>Variance: ${stats.variance.toFixed(2)}</li>
                <li>Standard Deviation: ${stats.stdDeviation.toFixed(2)}</li>
            </ul>
        `;
    }

    // Function to render normal distribution chart
    function renderNormalDistributionChart(chartId, label, groupedData) {
        const ctx = document.getElementById(chartId).getContext('2d');
        const datasets = [];
        let colors = [
            'rgba(75, 192, 192, 1)',
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)'
        ];
        let index = 0;

        // Loop through each region to calculate its normal distribution
        for (const region in groupedData) {
            const values = groupedData[region].map(d => d[label]);
            const mean = values.reduce((a, b) => a + b, 0) / values.length;
            const stdDeviation = Math.sqrt(values.reduce((a, b) => a + Math.pow(b - mean, 2), 0) / values.length);

            const normalDistributionData = [];
            for (let x = mean - 4 * stdDeviation; x <= mean + 4 * stdDeviation; x += 0.1) {
                const y = (1 / (stdDeviation * Math.sqrt(2 * Math.PI))) * Math.exp(-Math.pow(x - mean, 2) / (2 * Math.pow(stdDeviation, 2)));
                normalDistributionData.push({ x, y });
            }

            datasets.push({
                label: `Normal Distribution for ${region}`,
                data: normalDistributionData.map(point => ({ x: point.x.toFixed(2), y: point.y.toFixed(4) })),
                borderColor: colors[index % colors.length],
                backgroundColor: colors[index % colors.length].replace('1)', '0.2)'),
                borderWidth: 2,
                fill: false,
                showLine: true,
                tension: 0.4
            });

            index++;
        }

        if (window[chartId] && typeof window[chartId].destroy === 'function') {
            window[chartId].destroy();
        }

        window[chartId] = new Chart(ctx, {
            type: 'scatter',
            data: {
                datasets: datasets
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        type: 'linear',
                        position: 'bottom',
                        title: {
                            display: true,
                            text: label
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Probability'
                        },
                        beginAtZero: true
                    }
                }
            }
        });
    }
});
