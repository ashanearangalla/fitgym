<?php
session_start();
include '../connection.php'; // Include your database connection file

// Get packageID from the URL parameter
if (isset($_GET['packageID'])) {
    $packageID = $_GET['packageID'];
} 
// Check if subPackageID is provided for editing
$subPackageID = isset($_GET['subPackageID']) ? $_GET['subPackageID'] : null;
$duration = '';
$price = '';

if ($subPackageID) {
    // Fetch existing subpackage details for editing
    $fetchSubpackageQuery = "SELECT duration, price FROM subpackages WHERE subPackageID = ?";
    $stmt = $con->prepare($fetchSubpackageQuery);
    $stmt->bind_param("i", $subPackageID);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $duration = $result['duration'];
    $price = $result['price'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debra Admin Panel - <?php echo $subPackageID ? 'Edit' : 'Add'; ?> Subpackage</title>
    <link rel="stylesheet" href="../assets/css/styleadmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="admin-container">
        <?php include("sidemenu.php"); ?>

        <div class="content">
            <div class="content-header">
                <h1><?php echo $subPackageID ? 'Edit' : 'Add'; ?> Subpackage</h1>
            </div>
            
            <div id="create-subpackage" class="content-section-form">
                <form id="subpackage-form" action="dbconn/addSubpackage.php" method="POST">
                    <input type="hidden" name="packageID" value="<?php echo $packageID; ?>">
                    <?php if ($subPackageID): ?>
                        <input type="hidden" name="subPackageID" value="<?php echo $subPackageID; ?>">
                    <?php endif; ?>
                    <div class="form-group">
                        <div style="width: 500px;" class="col">
                            <label for="duration">Duration</label>
                            <select id="duration" name="duration" required>
                                <option value="1_month" <?php echo $duration == '1_month' ? 'selected' : ''; ?>>1 Month</option>
                                <option value="3_months" <?php echo $duration == '3_months' ? 'selected' : ''; ?>>3 Months</option>
                                <option value="6_months" <?php echo $duration == '6_months' ? 'selected' : ''; ?>>6 Months</option>
                                <option value="12_months" <?php echo $duration == '12_months' ? 'selected' : ''; ?>>12 Months</option>
                                <option value="1_session" <?php echo $duration == '1_session' ? 'selected' : ''; ?>>1 Session</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div style="width: 500px;" class="col">
                            <label for="price">Price</label>
                            <input type="number" id="price" name="price" placeholder="Price" value="<?php echo $price; ?>" required>
                        </div>
                    </div>
                    <button type="submit" class="submit-button-form"><?php echo $subPackageID ? 'Update' : 'Add'; ?> Subpackage</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
