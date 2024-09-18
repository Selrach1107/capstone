<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
     <!-- Bootstrap 5 CSS -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
     <!-- Font Awesome for Icons -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
     <!-- Chart.js for Graphs -->
     <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
     <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: #1be06d;
        }
        .navbar-brand img {
            height: 40px;
            width: auto;
        }
        .navbar-nav .nav-link {
            color: #fff !important;
            font-size: 1.1em;
            margin-right: 15px;
        }
        .nav-link:hover {
            background-color: #fff;
            color: #0b0a0a !important;
            border-radius: 5px;
        }
        .fa-icon {
            margin-right: 8px;
        }
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
        .logo-container {
            display: flex;
            align-items: center;
        }
        .logo-container img {
            max-height: 40px;
            width: auto;
        }
    </style>
</head>
<body>


<!-- Advanced Navigation Bar with Icons -->
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">
        <a class="navbar-brand logo-container" href="dashboard.php">
            <img src="pamilihannet.jpg" alt="PamilihanNet Logo">
        </a>
        <a class="navbar-brand" href="#">
            <img src="https://via.placeholder.com/40" alt="Profile Picture" id="profilePic">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-box fa-icon"></i>Product Management
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="addcat.html"><i class="fa-solid fa-list"></i> Add Category</a></li>
                        <li><a class="dropdown-item" href="add_products.html"><i class="fa-solid fa-square-plus"></i> Add Product</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fa-solid fa-eye"></i> View Product</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-chart-line fa-icon"></i>Sales Report</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-warehouse fa-icon"></i>Inventory Management</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-shield-alt fa-icon"></i>Security & Privacy Settings</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle fa-icon"></i>Profile Management
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="profile.html"><i class="fas fa-user fa-icon"></i>View Profile</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-edit fa-icon"></i>Edit Profile</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-cog fa-icon"></i>Account Settings</a></li>
                    </ul>
                </li>
                <!-- Logout Button -->
                <li class="nav-item">
                    <a class="nav-link" href="logout.php" onclick="logoutUser()"><i class="fas fa-sign-out-alt fa-icon"></i>Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2>Category List</h2>
    <table>
        <thead>
            <tr>
                <th>Serial No.</th>
                <th>Category Name</th>
                <th>Action</th>
             </tr>
        </thead>
    </table>
</div>
    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>


</body>
</html>
