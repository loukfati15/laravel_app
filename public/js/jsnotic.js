// CSV Export Functionality
document.getElementById('export-data').addEventListener('click', function () {
    exportDataToCSV();
});

function exportDataToCSV() {
    let csvContent = "data:text/csv;charset=utf-8,";

    // Add Notifications Data
    csvContent += "Notifications\n";
    csvContent += "Type,Description,Date\n";
    const notificationList = document.getElementById('notification-list');
    const notifications = notificationList.getElementsByTagName('li');
    Array.from(notifications).forEach(notification => {
        let notificationText = notification.textContent.trim().split(',').map(item => item.split(': ')[1]);
        csvContent += notificationText.join(",") + "\n";
    });

    // Add Graph Data
    csvContent += "\nGraph Data\n";
    const graphContainers = document.querySelectorAll('.graph-container canvas');
    graphContainers.forEach(graph => {
        let chart = window[graph.id]; // Access the Chart.js instance by canvas ID
        if (chart && chart.data && chart.data.labels) {
            let labels = chart.data.labels;
            let datasets = chart.data.datasets;
            csvContent += `${chart.options.scales.y.title.text}\n`; // Add chart title
            csvContent += "Date," + datasets.map(ds => ds.label).join(",") + "\n"; // Add header
            labels.forEach((label, index) => {
                let row = [label];
                datasets.forEach(ds => {
                    row.push(ds.data[index]);
                });
                csvContent += row.join(",") + "\n"; // Add data row
            });
            csvContent += "\n";
        }
    });

    // Trigger CSV download
    const encodedUri = encodeURI(csvContent);
    const link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", "dashboard_data.csv");
    document.body.appendChild(link); // Required for Firefox
    link.click();
    document.body.removeChild(link);
}

// PDF Export Functionality
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
                graph.style.display = 'block';
                html2canvas(graph).then(canvas => {
                    const imgData = canvas.toDataURL('image/png');
                    doc.addImage(imgData, 'PNG', 10, 20, 190, 100); // Adjust position and size
                    if (graphIndex < graphContainers.length - 1) {
                        doc.addPage();
                    }
                    graph.style.display = 'none'; // Hide graph after capture
                    graphIndex++;
                    addNextGraph();
                });
            } else {
                callback(); // Add notifications after graphs
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

        Array.from(notifications).forEach(notification => {
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