<?php
session_start();
$servername = "localhost"; 
$username = "root"; 
$password = "";
$dbname = "project";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["profile_picture"])) {
    $user_id = $_SESSION['user_id'];
    $upload_dir = "profile_pictures/"; // Directory where profile pictures will be uploaded
    $file_name = basename($_FILES["profile_picture"]["name"]);
    $target_file = $upload_dir . $file_name;

    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');</script>";
    } else {
        // Upload file to server
        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
            // Update database with profile picture file path
            $sql = "UPDATE user SET profile_picture = '$target_file' WHERE id = $user_id";
            if ($conn->query($sql) === TRUE) {
                
            } else {
                echo "<script>alert('Error updating profile picture:');</script>" . $conn->error;
            }
        } else {
            echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
        }
    }
}

$user_id = $_SESSION['user_id'];
$user_query = "SELECT * FROM user WHERE id = ?";
$user_stmt = $conn->prepare($user_query);
$user_stmt->bind_param("i", $user_id);
$user_stmt->execute();
$user_result = $user_stmt->get_result();
$user = $user_result->fetch_assoc();

$user_stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="container mt-5">
    <h2>User Profile</h2>

    <div class="card mt-3">
        <div class="card-header">Personal Information</div>
        <div class="mt-3">
            <div class="mt-3">
                <div class="rounded-circle border border-dark d-flex align-items-center justify-content-center" style="width: 90px; height: 90px; overflow: hidden; margin-left: 20px;">
                    <img src="<?= htmlspecialchars($user['profile_picture'] ?: 'uploads/default.png'); ?>" alt="Profile Picture" style="width: 100%; height: 100%; object-fit: cover;">
                </div>  
            </div>

            <!-- Form for Uploading Profile Picture -->
            <form style=" margin-left: 40px;" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                <div class="input-group">
                    <!-- Hidden file input -->
                    <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/*" onchange="updateFileName(this)" style="display: none;">

                    <!-- Choose file button with Camera Icon -->
                    <label for="profile_picture" style="cursor: pointer;">
                        <i class="fa fa-camera" aria-hidden="true"></i>
                    </label>

                    <!-- Add space between icons -->
                    <span class="mx-2"></span>

                    <!-- Upload button with Upload Icon -->
                    <button type="submit" style="border: none; background: none; padding: 0;">
                        <i class="fa fa-upload" aria-hidden="true"></i>
                    </button>
                </div>
            </form>
        </div>
        <div class="card-body">
            <p><strong>First Name:</strong> <?= htmlspecialchars($user['first_name']) ?></p>
            <p><strong>Middle Name:</strong> <?= htmlspecialchars($user['middle_name']) ?></p>
            <p><strong>Last Name:</strong> <?= htmlspecialchars($user['last_name']) ?></p>
            <p><strong>Phone Number:</strong> <?= htmlspecialchars($user['phone_number']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
        </div>
    </div>

    <!-- Button to open the update modal -->
    <button type="button" class="btn btn-primary mt-4" data-bs-toggle="modal" data-bs-target="#updateModal">
        Update Profile
    </button>

     <!-- Button to open the changepass modal -->
     <button type="button" class="btn btn-primary mt-4" data-bs-toggle="modal" data-bs-target="#changepassModal">
        Change Password
    </button>

    <!-- Update Profile Modal -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Update Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="update_profile.php" method="post">
                        <div class="mb-3">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" id="first_name" name="first_name" class="form-control" value="<?= htmlspecialchars($user['first_name']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="middle_name" class="form-label">Middle Name</label>
                            <input type="text" id="middle_name" name="middle_name" class="form-control" value="<?= htmlspecialchars($user['middle_name']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" id="last_name" name="last_name" class="form-control" value="<?= htmlspecialchars($user['last_name']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Phone Number</label>
                            <input type="number" id="phone_number" name="phone_number" class="form-control" value="<?= htmlspecialchars($user['phone_number']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div class="modal fade" id="changepassModal" tabindex="-1" aria-labelledby="changepassModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changepassModalLabel">Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="change_pass.php" method="post">
                    <div class="mb-3">
                    <label for="current_password" class="form-label">Current Password:</label>
                    <input type="password" name="current_password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="new_password" class="form-label">New Password:</label>
                    <input type="password" name="new_password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirm New Password:</label>
                    <input type="password" name="confirm_password" class="form-control" required>
                </div>

                
                    <button type="submit" class="btn btn-primary">Change Password</button>
                
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>
