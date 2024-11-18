<?php
include '../conn.php';

session_start();

// Check if the user is logged in and has the admin role
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login_form.php'); // Redirect to login page if not authorized
    exit();
}

// Fetch registration requests
$stmt = $conn->prepare("SELECT * FROM seller_reg_requests");
$stmt->execute();
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch rider registration requests
$stmt_rider = $conn->prepare("SELECT * FROM rider_reg_requests");
$stmt_rider->execute();
$rider_requests = $stmt_rider->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Vendor Registration Requests</h1>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Store Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($requests as $request): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($request['store_name']); ?></td>
                        <td>
                            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#requestModal<?php echo $request['id']; ?>">
                                View Details
                            </button>
                            
                            <!-- Modal for registration request -->
                            <div class="modal fade" id="requestModal<?php echo $request['id']; ?>" tabindex="-1" aria-labelledby="requestModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="requestModalLabel">Registration Request Details</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>First Name:</strong> <?php echo htmlspecialchars($request['first_name']); ?></p>
                                            <p><strong>Middle Name:</strong> <?php echo htmlspecialchars($request['middle_name']); ?></p>
                                            <p><strong>Last Name:</strong> <?php echo htmlspecialchars($request['last_name']); ?></p>
                                            <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($request['phone_number']); ?></p>
                                            <p><strong>Email:</strong> <?php echo htmlspecialchars($request['email']); ?></p>
                                            <p><strong>Store Name:</strong> <?php echo htmlspecialchars($request['store_name']); ?></p>
                                            <p><strong>Business Permit Number:</strong> <?php echo htmlspecialchars($request['business_permit_number']); ?></p>
                                        </div>
                                        <div class="modal-footer">
                                            <form method="POST" action="admin_dashboard.php" class="d-inline">
                                                <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
                                                <input type="submit" name="approve_seller" class="btn btn-success" value="Approve">
                                                <input type="submit" name="reject_seller" class="btn btn-danger" value="Reject">
                                            </form>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h1 class="mb-4">Rider Registration Requests</h1>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rider_requests as $request): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($request['first_name'] . ' ' . $request['last_name']); ?></td>
                        <td>
                            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#riderModal<?php echo $request['id']; ?>">View Details</button>

                            <!-- Modal for Rider Registration Request -->
                            <div class="modal fade" id="riderModal<?php echo $request['id']; ?>" tabindex="-1" aria-labelledby="requestModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="requestModalLabel">Rider Registration Request Details</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>First Name:</strong> <?php echo htmlspecialchars($request['first_name']); ?></p>
                                            <p><strong>Middle Name:</strong> <?php echo htmlspecialchars($request['middle_name']); ?></p>
                                            <p><strong>Last Name:</strong> <?php echo htmlspecialchars($request['last_name']); ?></p>
                                            <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($request['phone_number']); ?></p>
                                            <p><strong>Email:</strong> <?php echo htmlspecialchars($request['email']); ?></p>
                                            <p><strong>Driver License Number:</strong> <?php echo htmlspecialchars($request['driver_license_number']); ?></p>
                                        </div>
                                        <div class="modal-footer">
                                            <form method="POST" action="admin_dashboard.php" class="d-inline">
                                                <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
                                                <input type="submit" name="approve_rider" class="btn btn-success" value="Approve">
                                                <input type="submit" name="reject_rider" class="btn btn-danger" value="Reject">
                                            </form>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <a href="logout.php" onclick="return confirm('Are you sure you want to log out?');">log out</a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Approve or Reject logic for Seller and Rider Registration Requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $requestId = $_POST['request_id'];

    // Approve Seller Registration Request
    if (isset($_POST['approve_seller'])) {
        // Fetch the seller request data
        $stmt = $conn->prepare("SELECT * FROM seller_reg_requests WHERE id = :id");
        $stmt->execute(['id' => $requestId]);
        $requestData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($requestData) {
            // Insert into seller table
            $insertStmt = $conn->prepare("INSERT INTO seller 
                (first_name, middle_name, last_name, phone_number, email, store_name, business_permit_number, password)
                VALUES (:first_name, :middle_name, :last_name, :phone_number, :email, :store_name, :business_permit_number, :password)");

            $insertStmt->bindParam(':first_name', $requestData['first_name'], PDO::PARAM_STR);
            $insertStmt->bindParam(':middle_name', $requestData['middle_name'], PDO::PARAM_STR);
            $insertStmt->bindParam(':last_name', $requestData['last_name'], PDO::PARAM_STR);
            $insertStmt->bindParam(':phone_number', $requestData['phone_number'], PDO::PARAM_STR);
            $insertStmt->bindParam(':email', $requestData['email'], PDO::PARAM_STR);
            $insertStmt->bindParam(':store_name', $requestData['store_name'], PDO::PARAM_STR);
            $insertStmt->bindParam(':business_permit_number', $requestData['business_permit_number'], PDO::PARAM_STR);
            $insertStmt->bindParam(':password', $requestData['password'], PDO::PARAM_STR); // Use hashed password
            $insertStmt->execute();

            // Delete from seller registration requests table
            $deleteStmt = $conn->prepare("DELETE FROM seller_reg_requests WHERE id = :id");
            $deleteStmt->execute(['id' => $requestId]);

            echo "<script>alert('Seller registration approved successfully.'); window.location.reload();</script>";
        }
    } 
    // Reject Seller Registration Request
    elseif (isset($_POST['reject_seller'])) {
        // Delete from seller registration requests table
        $deleteStmt = $conn->prepare("DELETE FROM seller_reg_requests WHERE id = :id");
        $deleteStmt->execute(['id' => $requestId]);

        echo "<script>alert('Seller registration rejected successfully.'); window.location.reload();</script>";
    } 
    // Approve Rider Registration Request
    elseif (isset($_POST['approve_rider'])) {
        // Fetch the rider request data
        $stmt = $conn->prepare("SELECT * FROM rider_reg_requests WHERE id = :id");
        $stmt->execute(['id' => $requestId]);
        $requestData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($requestData) {
            // Insert into rider table
            $insertStmt = $conn->prepare("INSERT INTO rider 
                (first_name, middle_name, last_name, phone_number, email, driver_license_number, password)
                VALUES (:first_name, :middle_name, :last_name, :phone_number, :email, :driver_license_number, :password)");

            $insertStmt->bindParam(':first_name', $requestData['first_name'], PDO::PARAM_STR);
            $insertStmt->bindParam(':middle_name', $requestData['middle_name'], PDO::PARAM_STR);
            $insertStmt->bindParam(':last_name', $requestData['last_name'], PDO::PARAM_STR);
            $insertStmt->bindParam(':phone_number', $requestData['phone_number'], PDO::PARAM_STR);
            $insertStmt->bindParam(':email', $requestData['email'], PDO::PARAM_STR);
            $insertStmt->bindParam(':driver_license_number', $requestData['driver_license_number'], PDO::PARAM_STR);
            $insertStmt->bindParam(':password', $requestData['password'], PDO::PARAM_STR); // Use hashed password
            $insertStmt->execute();

            // Delete from rider registration requests table
            $deleteStmt = $conn->prepare("DELETE FROM rider_reg_requests WHERE id = :id");
            $deleteStmt->execute(['id' => $requestId]);

            echo "<script>alert('Rider registration approved successfully.'); window.location.reload();</script>";
        }
    } 
    // Reject Rider Registration Request
    elseif (isset($_POST['reject_rider'])) {
        // Delete from rider registration requests table
        $deleteStmt = $conn->prepare("DELETE FROM rider_reg_requests WHERE id = :id");
        $deleteStmt->execute(['id' => $requestId]);

        echo "<script>alert('Rider registration rejected successfully.'); window.location.reload();</script>";
    }
}
?>

