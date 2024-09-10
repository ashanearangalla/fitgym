<?php
session_start();

// Database connection
include('../connection.php');

// Fetch packages
$query = "SELECT * FROM packages";
$result = mysqli_query($con, $query);
$packages = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debra Admin Panel - Packages Overview</title>
    <link rel="stylesheet" href="../assets/css/styleadmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Add any additional styles specific to viewPackages.php */
    </style>
</head>
<body>
    <div class="admin-container">
        <?php include("sidemenu.php"); ?>

        <div class="content">
            <div class="content-header">
                <h1>Packages</h1>
            </div>
            
            <div class="content-section">
                <table class="event-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Package Name</th>
                            <th>Package Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($packages) {
                            $count = 1;
                            foreach ($packages as $package) {
                                echo "<tr>
                                        <td>{$count}</td>
                                        <td>{$package['packageName']}</td>
                                        <td>{$package['packageType']}</td>
                                        <td>
                                        <a href='viewSubpackages.php?packageID={$package['packageID']}' class='view-button'>View Subpackages</a>
                                            <a href='newPackage.php?packageID={$package['packageID']}' class='edit-button'>Edit</a>
                                            
                                            <form method='post' action='' style='display:inline-block;'>
                                                <input type='hidden' name='packageID' value='{$package['packageID']}'>
                                                <button type='submit' name='delete' class='delete-button'>Delete</button>
                                            </form>
                                        </td>
                                    </tr>";
                                $count++;
                            }
                        } else {
                            echo "<tr><td colspan='4'>No data available</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="bottom-box">
                <a href="newPackage.php"><button class="button-main">Add Package</button></a>
            </div>
        </div>
    </div>
    <script src="../assets/js/admin.js"></script>
</body>
</html>

<?php
// Handle delete request
if (isset($_POST['delete'])) {
    $packageID = $_POST['packageID'];
    
    // Delete package query
    $deleteQuery = "DELETE FROM packages WHERE packageID = ?";
    $stmt = $con->prepare($deleteQuery);
    $stmt->bind_param('i', $packageID);
    
    if ($stmt->execute()) {
        echo "<script>alert('Package deleted successfully'); window.location.href='viewPackages.php';</script>";
    } else {
        echo "<script>alert('Error deleting package'); window.location.href='viewPackages.php';</script>";
    }
}
?>