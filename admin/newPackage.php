<?php
session_start();
include '../connection.php'; // Include your database connection file

// Check if packageID is provided for editing
$packageID = isset($_GET['packageID']) ? $_GET['packageID'] : null;
$packageName = '';
$packageType = '';

if ($packageID) {
    // Fetch existing package details for editing
    $fetchPackageQuery = "SELECT packageName, packageType FROM packages WHERE packageID = ?";
    $stmt = $con->prepare($fetchPackageQuery);
    $stmt->bind_param("i", $packageID);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $packageName = $result['packageName'];
    $packageType = $result['packageType'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debra Admin Panel - <?php echo $packageID ? 'Edit' : 'Add'; ?> Package</title>
    <link rel="stylesheet" href="../assets/css/styleadmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="admin-container">
        <?php include("sidemenu.php"); ?>

        <div class="content">
            <div class="content-header">
                <h1><?php echo $packageID ? 'Edit' : 'Add'; ?> Package</h1>
            </div>
            
            <div id="create-package" class="content-section-form">
                <form id="package-form" action="dbconn/addPackage.php" method="POST">
                    <?php if ($packageID): ?>
                        <input type="hidden" name="packageID" value="<?php echo $packageID; ?>">
                    <?php endif; ?>
                    <div class="form-group">
                        <div style="width: 500px;" class="col">
                            <label for="packageName">Package Name</label>
                            <input type="text" id="packageName" name="packageName" placeholder="Package Name" value="<?php echo $packageName; ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div style="width: 500px;" class="col">
                            <label for="packageType">Package Type</label>
                            <select id="packageType" name="packageType" required>
                                <option value="individual" <?php echo $packageType == 'individual' ? 'selected' : ''; ?>>Individual</option>
                                <option value="family" <?php echo $packageType == 'family' ? 'selected' : ''; ?>>Family</option>
                                <option value="casual" <?php echo $packageType == 'casual' ? 'selected' : ''; ?>>Casual</option>
                                <option value="couple" <?php echo $packageType == 'couple' ? 'selected' : ''; ?>>Couple</option>
                                <option value="personal_training" <?php echo $packageType == 'personal_training' ? 'selected' : ''; ?>>Personal Training</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="submit-button-form"><?php echo $packageID ? 'Update' : 'Add'; ?> Package</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
