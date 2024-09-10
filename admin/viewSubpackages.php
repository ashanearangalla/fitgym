<?php
session_start();

// Database connection
include('../connection.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') { 

        
    header("Location: viewPackages.php");
       
}

// Fetch subpackages based on packageID from GET parameter
if (isset($_GET['packageID'])) {
    $packageID = $_GET['packageID'];
    
    // Fetch subpackages for the specified packageID
    $query = "SELECT * FROM subpackages WHERE packageID = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('i', $packageID);
    $stmt->execute();
    $result = $stmt->get_result();
    $subpackages = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $_SESSION['error_message'] = 'Invalid request. Package ID is required.';
    header("Location: viewPackages.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debra Admin Panel - Subpackages Overview</title>
    <link rel="stylesheet" href="../assets/css/styleadmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Add any additional styles specific to viewSubpackages.php */
    </style>
</head>
<body>
    <div class="admin-container">
        <?php include("sidemenu.php"); ?>

        <div class="content">
            <div class="content-header">
                <h1>Subpackages for Package ID: <?php echo $packageID; ?></h1>
            </div>
            
            <div class="content-section">
                <table class="event-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Duration</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($subpackages)) {
                            $count = 1;
                            foreach ($subpackages as $subpackage) {
                                echo "<tr>
                                        <td>{$count}</td>
                                        <td>{$subpackage['duration']}</td>
                                        <td>{$subpackage['price']}</td>
                                        <td>
                                            <a href='newSubpackage.php?subPackageID={$subpackage['subPackageID']}&packageID={$subpackage['packageID']}' class='edit-button'>Edit</a>
                                            <form method='post' action='' style='display:inline-block;'>
                                                <input type='hidden' name='subPackageID' value='{$subpackage['subPackageID']}'>
                                                <button type='submit' name='delete' class='delete-button'>Delete</button>
                                            </form>
                                        </td>
                                    </tr>";
                                $count++;
                            }
                        } else {
                            echo "<tr><td colspan='4'>No subpackages available for this package.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="bottom-box">
                <a href="newSubpackage.php?packageID=<?php echo $packageID; ?>"><button class="button-main">Add Subpackage</button></a>
               
            </div>
        </div>
    </div>
    <script src="../assets/js/admin.js"></script>
</body>
</html>

<?php
// Handle delete request
if (isset($_POST['delete'])) {
    $subPackageID = $_POST['subPackageID'];
    
    // Delete subpackage query
    $deleteQuery = "DELETE FROM subpackages WHERE subPackageID = ?";
    $stmt = $con->prepare($deleteQuery);
    $stmt->bind_param('i', $subPackageID);
    
    if ($stmt->execute()) {
        echo "<script>alert('Subpackage deleted successfully'); window.location.href='viewSubpackages.php?packageID=$packageID';</script>";
    } else {
        echo "<script>alert('Error deleting subpackage'); window.location.href='viewSubpackages.php?packageID=$packageID';</script>";
    }
}
?>