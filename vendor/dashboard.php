<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login_form.php");
    exit();
}

// Disable caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Dashboard</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Chart.js for Graphs -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .dashboard-card {
            background-color: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .graph-container {
            padding: 20px;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .card-icon {
            font-size: 2.5rem;
            color: #33cd10;
        }
    </style>
</head>
<body>

    <?php
        include 'sidebar.php';
    ?>
    
    <!-- Vendor Dashboard Content -->
    <div class="container mt-5">
        <h2>Welcome, Vendor!</h2>
        <p class="text-muted">Here's a quick overview of your activities.</p>

        <!-- Dashboard Cards Section -->
        <div class="row">
            <!-- Add Product -->
            <div class="col-md-4">
                <div class="dashboard-card text-center">
                    <i class="fas fa-box card-icon"></i>
                    <h5>Add New Product</h5>
                    <a href="add_product.php" class="btn btn-success mt-3">Add Product</a>
                </div>
            </div>
            <!-- View Products -->
            <div class="col-md-4">
                <div class="dashboard-card text-center">
                    <i class="fas fa-list card-icon"></i>
                    <h5>View Products</h5>
                    <a href="prodlist.php" class="btn btn-success mt-3">View Products</a>
                </div>
            </div>
            <!-- Sales Report -->
            <div class="col-md-4">
                <div class="dashboard-card text-center">
                    <i class="fas fa-chart-line card-icon"></i>
                    <h5>Sales Report</h5>
                    <a href="#" class="btn btn-success mt-3">View Sales</a>
                </div>
            </div>
        </div>

        <!-- Sales Performance Chart Section -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="graph-container">
                    <div class="d-flex justify-content-between">
                        <h5><i class="fas fa-chart-bar"></i> Sales Performance</h5>
                        <!-- Dropdown Filter for Report Type -->
                        <div class="dropdown">
                            <button class="btn btn-success dropdown-toggle" type="button" id="reportFilter" data-bs-toggle="dropdown" aria-expanded="false">
                                Select Report Type
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="reportFilter">
                                <li><a class="dropdown-item" href="#" onclick="updateChart('daily')">Daily</a></li>
                                <li><a class="dropdown-item" href="#" onclick="updateChart('weekly')">Weekly</a></li>
                                <li><a class="dropdown-item" href="#" onclick="updateChart('monthly')">Monthly</a></li>
                            </ul>
                        </div>
                    </div>
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <!-- Chart.js Sales Performance Graph -->
    <script>
        const ctx = document.getElementById('salesChart').getContext('2d');
        let salesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Sales (₱)',
                    data: [3000, 5000, 7000, 6000, 8000, 5000, 4000],
                    backgroundColor: '#1be06d',  // green color
                    borderColor: '#0056b3',      // Darker blue color
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Function to Update the Chart Data based on Report Type
        function updateChart(type) {
            if (type === 'daily') {
                salesChart.data.labels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                salesChart.data.datasets[0].data = [3000, 5000, 7000, 6000, 8000, 5000, 4000];
            } else if (type === 'weekly') {
                salesChart.data.labels = ['Week 1', 'Week 2', 'Week 3', 'Week 4'];
                salesChart.data.datasets[0].data = [20000, 25000, 18000, 22000];
            } else if (type === 'monthly') {
                salesChart.data.labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
                salesChart.data.datasets[0].data = [120000, 150000, 170000, 160000, 190000, 210000];
            }
            salesChart.update();
        }
    </script>

</body>
</html>
