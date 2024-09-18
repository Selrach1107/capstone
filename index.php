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
        body {
            background-image: url(images/homeback1.jpg);
            font-family: 'Poppins', sans-serif;
        }
        .navbar {
            background-color: #fff;
        }
        .navbar-brand img {
            height: 40px;
            width: auto;
        }
        .navbar-nav .nav-link {
            color: #080808 !important;
            font-size: 1.1em;
            margin-right: 15px;
        }
        .nav-link:hover {
            /*background-color: #55f17c;*/
            color: #16d666 !important;
            border-radius: 5px;
        }
        .dropdown-menu {
            min-width: 250px;
        }
        .dropdown-menu .dropdown-item:hover {
            /*background-color: #c1c5c2;*/
            color: #16d666;
        }
        .logo-container {
            display: flex;
            align-items: center;
            height: 100%;
        }
        .logo-container img {
            height: 100%;
            max-height: 85px;
            width: 400px;
        }
        .navbar-nav .nav-link.badge.bg-success {
            background-color: lightgreen;
        }
        .card {
            background-color: rgba(255, 255, 255, 0.8);
            border: none;
            margin-left: 50px;
            padding: 15px;
        }
        .card-body h3 .nav-link {
            color: rgb(10, 10, 10);
        }
        .card-body h3 {
            background-color: rgb(126, 236, 126);
            text-align: center;
            padding: 10px;
            border-radius: 10px;
        }
    </style>
</head>
<body>

    <!-- Advanced Navigation Bar with Icons -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand logo-container" href="home_page.html">
                <img src="images/pamilihannet.jpg" alt="PamilihanNet Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">HOME</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">CONTACT</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">ABOUT</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">JOIN US</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="vendor/reg_form.php">Become a Seller</a></li>
                            <li><a class="dropdown-item" href="rider/reg_form.php">Become a Rider</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="background-color: lightgreen; border-radius: 5px;">ORDER NOW</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="d-flex justify-content-left">
        <div class="card w-50 mt-5">
            <div class="card-body">
                <h1 class="fw-bolder">From Market Stalls<br>
                    to your Doorstep.</h1>
                <br>
                <h5>Empowers our local sellers to ensure that their hard work<br> and high-quality produce are 
                    accessible to everyone.
                </h5>
                <br>
                <br>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
