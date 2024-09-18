<?php
$servername = "localhost"; // your database server
$username = "root"; // your database username
$password = ""; // your database password
$dbname = "pamilihannet";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Failed " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login System with Email Verification</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    
</head>
<body>
        <!-- Registration Area -->
        <div id="registrationForm">
            <h2 class="text-center">Seller Registration Form</h2>
            <p class="text-center">Fill in your personal details.</p>
            <form action="../endpoint/add-user.php" method="POST">
                <div class="form-group row">
                    <div class="col-4">
                        <label for="firstName">First Name:</label>
                        <input type="text" class="form-control" id="firstName" name="first_name" required>
                    </div>
                    <div class="col-4">
                        <label for="middleName">Middle Name:</label>
                        <input type="text" class="form-control" id="middleName" name="middle_name">
                    </div>
                    <div class="col-4">
                        <label for="lastName">Last Name:</label>
                        <input type="text" class="form-control" id="lastName" name="last_name" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-5">
                        <label for="phoneNumber">Phone Number:</label>
                        <input type="number" class="form-control" id="phoneNumber" name="phone_number" maxlength="11" required>
                    </div>
                    <div class="col-7">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="store_name">Store Name:</label>
                    <input type="text" class="form-control" id="store_name" name="store_name" required>
                </div>
                <div class="form-group">
                    <label for="businessPermitNumber">Business Permit Number:</label>
                    <input type="text" class="form-control" id="businessPermitNumber" name="business_permit_number" required>
                </div>
                <div class="form-group">
                    <label for="businessPermitImage">Business Permit Image:</label>
                    <input type="file" class="form-control" id="businessPermitImage" name="business_permit_image" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="confirmPassword">Confirm Password:</label>
                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                </div>
                <h6 class="text-center">Already have an account? <a href="login_form.php">Login</a></h6>
                <button type="submit" class="btn btn-dark form-control" name="register">Register</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('registrationForm');
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirmPassword');

        form.addEventListener('submit', function(event) {
            const passwordValue = password.value;
            const confirmPasswordValue = confirmPassword.value;

            // Check if passwords match
            if (passwordValue !== confirmPasswordValue) {
                alert('Passwords do not match.');
                event.preventDefault();
                return;
            }

            // Check password strength
            const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
            if (!passwordPattern.test(passwordValue)) {
                alert('Password must be at least 8 characters long and include uppercase letters, lowercase letters, digits, and special characters.');
                event.preventDefault();
                return;
            }
        });
    });

    </script>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

</body>
</html>
