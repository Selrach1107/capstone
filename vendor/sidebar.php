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
            height: 100%; 
        }
        .logo-container img {
            height: 100%; 
            max-height: 85px; 
            width: 170px; 
        }
</style>
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
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle fa-icon"></i>Profile Management
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="profile.php"><i class="fas fa-user fa-icon"></i>View Profile</a></li>
                            <!--<li><a class="dropdown-item" href="#"><i class="fas fa-edit fa-icon"></i>Edit Profile</a></li>-->
                            <li><a class="dropdown-item" href="change_pass.php"><i class="fas fa-shield-alt fa-icon"></i>Privacy Settings</a></li>
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