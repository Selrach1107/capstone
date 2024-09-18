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
            background-color: #fff;
        }
        .navbar-brand img {
            height: 40px;
            width: auto;
        }
        .navbar-nav .nav-link {
            color: #080808  !important;
            font-size: 1.1em;
            margin-right: 15px;
        }
        .nav-link:hover {
            background-color: #c1c5c2;
            color: #080808  !important;
            border-radius: 5px;
        }
        .dropdown-menu {
            min-width: 250px;
        }
        .dropdown-menu .dropdown-item:hover {
            background-color: #c1c5c2;
            color: white;
        }
        .fa-icon {
            margin-right: 8px;
        }
        .logo-container {
            display: flex;
            align-items: center;
            height: 100%; /* Make sure the container takes full height */
        }
        .logo-container img {
            height: 100%; /* Set the logo height to fill the navbar */
            max-height: 85px; /* Match the default navbar height or adjust as necessary */
            width: 170px; /* Keep the aspect ratio */
        }
    </style>
</head>
<body>


 <!-- Advanced Navigation Bar with Icons -->
 <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand logo-container" href="dashboard.php">
                <img src="../images/pamilihannet.jpg" alt="PamilihanNet Logo">
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
                            <li><a class="dropdown-item" href="add_category.php"><i class="fa-solid fa-list"></i>Add Category</a></li>
                            <li><a class="dropdown-item" href="add_product.php"><i class="fa-solid fa-square-plus"></i> Add Product</a></li>
                            <li><a class="dropdown-item" href="prodlist.php"><i class="fa-solid fa-eye"></i>View Product</a></li>
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
                        <a class="nav-link" href="logout.php" onclick="return confirm('Are you sure you want to log out?');"><i class="fas fa-sign-out-alt fa-icon"></i>Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


<div class="d-flex justify-content-center">
    <div class="card w-50 mt-4">
        <h5 class="card-header"> CATEGORY</h5>
        <div class="card-body">
            <div class="container mt-2">
                <form>
                    <div class="mb-3">
                        <label for="category" class="form-label">Add Category</label>
                        <input type="text" class="form-control" id="category" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
                <br>
            </div>
        </div>
    </div>
</div>
<div class="container mt-5">
    <h2>Category List</h2>
    <table class="table table-success">
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
