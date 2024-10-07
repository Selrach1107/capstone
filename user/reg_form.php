<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User registration</title>
</head>
<body>
<form action="../endpoint/add-user.php" method="POST">               
                    <label for="firstName">First Name:</label>
                    <input type="text" class="form-control" id="firstName" name="first_name" required>
                    <label for="middleName">Middle Name:</label>
                    <input type="text" class="form-control" id="middleName" name="middle_name">
                    <label for="lastName">Last Name:</label>
                    <input type="text" class="form-control" id="lastName" name="last_name" required>
                    <label for="phoneNumber">Phone Number:</label>
                    <input type="number" class="form-control" id="phoneNumber" name="phone_number" maxlength="11" required>
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <label for="confirmPassword">Confirm Password:</label>
                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                <h6 class="text-center">Already have an account? <a href="login_form.php">Login</a></h6>
                <button type="submit" class="btn btn-dark form-control" name="register">Register</button>
            </form>
</body>
</html>