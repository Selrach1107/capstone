<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url(images/homeback1.jpg);
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        .navbar {
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .navbar-brand img {
            height: 60px;
            width: auto;
        }
        .navbar-nav .nav-link {
            color: #080808 !important;
            font-size: 1.1em;
            margin-right: 15px;
        }
        .nav-link:hover {
            color: #16d666 !important;
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
        .card {
            background-color: rgba(255, 255, 255, 0.8);
            border: none;
            padding: 15px;
            border-radius: 15px;
        }
        .card-body h1 {
            font-weight: 700;
            text-align: center;
        }
        .card-body h5 {
            text-align: center;
            color: #555;
        }
    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand logo-container" href="index.php">
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
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#sellerLoginModal">Become a Seller</a></li>
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#riderLoginModal">Become a Rider</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#userLoginModal" style="background-color: lightgreen; border-radius: 5px;">ORDER NOW</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="d-flex justify-content-center align-items-center" style="height: 80vh;">
        <div class="card w-75">
            <div class="card-body">
                <h1>From Market Stalls<br> to Your Doorstep.</h1>
                <h5>Empowering local sellers to bring high-quality produce straight to your home.</h5>
            </div>
        </div>
    </div>
    <div class="container-fluid bg-light">
        <footer class="footer"> 
            <div class="container">
            <center>
                <p>Copyright &copy PamilihanNet. All Rights Reserved.</p>
                <p>This website is developed by Christian Charles</p>
                <br>
            </center>
            </div>
        </footer>
    </div>
    

    <!-- Seller Login Modal -->
    <div class="modal fade" id="sellerLoginModal" tabindex="-1" aria-labelledby="sellerLoginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sellerLoginModalLabel">Seller Login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="seller/login_form.php" method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Login</button>
                        <h6 class="text-center">Create account? <a href="#" data-bs-toggle="modal" data-bs-target="#sellerRegModal">Sign Up</a></h6>
                        <h6 class="text-center">
                            <a href="endpoint/seller_forgot_pass.php">Forgot Password?</a>
                        </h6>
                    </form>
                </div>
            </div>
        </div>
    </div>

     <!-- Rider Login Modal -->
     <div class="modal fade" id="riderLoginModal" tabindex="-1" aria-labelledby="riderLoginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="riderLoginModalLabel">Rider Login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="rider/login_form.php" method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Login</button>
                        <h6 class="text-center">Create account? <a href="#" data-bs-toggle="modal" data-bs-target="#riderRegModal">Sign Up</a></h6>
                        <h6 class="text-center">
                            <a href="endpoint/rider_forgot_pass.php">Forgot Password?</a>
                        </h6>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- User Login Modal -->
    <div class="modal fade" id="userLoginModal" tabindex="-1" aria-labelledby="userLoginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userLoginModalLabel">User Login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="user/login_form.php" method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Login</button>
                        <h6 class="text-center">Create account? <a href="#" data-bs-toggle="modal" data-bs-target="#userRegModal">Sign Up</a></h6>
                        <h6 class="text-center">
                            <a href="endpoint/user_forgot_pass.php">Forgot Password?</a>
                        </h6>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Seller Registration Modal -->
    <div class="modal fade" id="sellerRegModal" tabindex="-1" aria-labelledby="sellerRegModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sellerRegModalLabel">Seller Registration</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="endpoint/add-seller.php" method="POST">
                        <div class="mb-3">
                            <label for="firstName">First Name:</label>
                            <input type="text" class="form-control" id="firstName" name="first_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="middleName">Middle Name:</label>
                            <input type="text" class="form-control" id="middleName" name="middle_name">
                        </div>
                        <div class="mb-3">
                            <label for="lastName">Last Name:</label>
                            <input type="text" class="form-control" id="lastName" name="last_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="phoneNumber">Phone Number:</label>
                            <input type="number" class="form-control" id="phoneNumber" name="phone_number" maxlength="11" required>
                        </div>
                        <div class="mb-3">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="store_name">Store Name:</label>
                            <input type="text" class="form-control" id="store_name" name="store_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="businessPermitNumber">Business Permit Number:</label>
                            <input type="text" class="form-control" id="businessPermitNumber" name="business_permit_number" required>
                        </div>
                        <div class="mb-3">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirmPassword">Confirm Password:</label>
                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                        </div>
                        <h6 class="text-center">Already have an account? <a href="#" data-bs-toggle="modal" data-bs-target="#sellerLoginModal">Login</a></h6>
                        <button type="submit" class="btn btn-success form-control" name="register">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

   

    <!-- Rider Registration Modal -->
    <div class="modal fade" id="riderRegModal" tabindex="-1" aria-labelledby="riderRegModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="riderRegModalLabel">Rider Registration</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="endpoint/add-rider.php" method="POST">
                        <div class="mb-3">
                            <label for="firstName">First Name:</label>
                            <input type="text" class="form-control" id="firstName" name="first_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="middleName">Middle Name:</label>
                            <input type="text" class="form-control" id="middleName" name="middle_name">
                        </div>
                        <div class="mb-3">
                            <label for="lastName">Last Name:</label>
                            <input type="text" class="form-control" id="lastName" name="last_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="phoneNumber">Phone Number:</label>
                            <input type="number" class="form-control" id="phoneNumber" name="phone_number" maxlength="11" required>
                        </div>
                        <div class="mb-3">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="driverlicensenumber">Driver License Number:</label>
                            <input type="text" class="form-control" id="driverlicensenumber" name="driver_license_number" required>
                        </div>
                        <div class="mb-3">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirmPassword">Confirm Password:</label>
                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                        </div>
                        <h6 class="text-center">Already have an account? <a href="#" data-bs-toggle="modal" data-bs-target="#riderLoginModal">Login</a></h6>
                        <button type="submit" class="btn btn-success form-control" name="register">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    

    <!-- User Registration Modal -->
    <div class="modal fade" id="userRegModal" tabindex="-1" aria-labelledby="userRegModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userRegModalLabel">User Registration</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="endpoint/add-user.php" method="POST">
                        <div class="mb-3">
                            <label for="firstName">First Name:</label>
                            <input type="text" class="form-control" id="firstName" name="first_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="middleName">Middle Name:</label>
                            <input type="text" class="form-control" id="middleName" name="middle_name">
                        </div>
                        <div class="mb-3">
                            <label for="lastName">Last Name:</label>
                            <input type="text" class="form-control" id="lastName" name="last_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="phoneNumber">Phone Number:</label>
                            <input type="number" class="form-control" id="phoneNumber" name="phone_number" maxlength="11" required>
                        </div>
                        <div class="mb-3">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirmPassword">Confirm Password:</label>
                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                        </div>
                        <h6 class="text-center">Already have an account? <a href="#" data-bs-toggle="modal" data-bs-target="#userLoginModal">Login</a></h6>
                        <button type="submit" class="btn btn-success form-control" name="register">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            // Check the URL hash and open the corresponding modal
            var modalId = null;

            // Determine which modal to open based on the URL hash
            switch (window.location.hash) {
                case '#sellerRegModal':
                    modalId = 'sellerRegModal';
                    break;
                case '#riderRegModal':
                    modalId = 'riderRegModal';
                    break;
                case '#userRegModal':
                    modalId = 'userRegModal';
                    break;
                case '#userLoginModal':
                    modalId = 'userLoginModal';
                    break;
                case '#uriderLoginModal':
                    modalId = 'userLoginModal';
                    break;
                case '#sellerLoginModal':
                    modalId = 'userLoginModal';
                    break;
            }

            // If a modal ID is set, show the modal
            if (modalId) {
                var myModal = new bootstrap.Modal(document.getElementById(modalId), {
                    keyboard: false
                });
                myModal.show();
            }
        };
    </script>


    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>
