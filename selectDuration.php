<?php
session_start();
include 'connection.php';

// Fetch package name and subpackages based on packageID from GET parameter
if (isset($_GET['packageID'])) {
    $packageID = $_GET['packageID'];
    $userID = $_SESSION["userID"];
    $memberID = $_SESSION["memberID"];
    // Fetch package name
    $packageQuery = "SELECT packageName FROM packages WHERE packageID = ?";
    $packageStmt = $con->prepare($packageQuery);
    $packageStmt->bind_param('i', $packageID);
    $packageStmt->execute();
    $packageResult = $packageStmt->get_result();
    $package = $packageResult->fetch_assoc();
    
    // Fetch subpackages for the specified packageID
    $query = "SELECT * FROM subpackages WHERE packageID = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('i', $packageID);
    $stmt->execute();
    $result = $stmt->get_result();
    $subpackages = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $_SESSION['error_message'] = 'Invalid request. Package ID is required.';
    header("Location: packages.php");
    exit();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Duration - FITNESS WORLD</title>
    <link rel="stylesheet" href="assets/css/stylemember.css">
</head>
<body>
    <header>
        <h1>FITNESS WORLD</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="index.php#about">About Us</a>
            <a href="index.php#trainers">Trainers</a>
            <a href="index.php#classes">Classes</a>
            <a href="packages.php">Packages</a>
            <a href="index.php#contact">Contact</a>
            <a href="login.php">Login/Sign Up</a>
        </nav>
    </header>
    <div class="membership-container">
        <h1>Choose Duration for <?php echo htmlspecialchars($package['packageName']); ?> Package</h1>
        <form action="enrollMember.php" method="post">
            <input type="hidden" name="packageID" value="<?php echo $packageID; ?>">
            <input type="hidden" name="userID" value="<?php echo $userID; ?>">
            <input type="hidden" name="memberID" value="<?php echo $memberID; ?>">
            <?php if (!empty($subpackages)): ?>
                <div class="duration-options">
                    <?php foreach ($subpackages as $subpackage): ?>
                        <div class="duration-option">
                            <input type="radio" id="duration_<?php echo $subpackage['subPackageID']; ?>" name="subPackageID" value="<?php echo $subpackage['subPackageID']; ?>" required>
                            <label for="duration_<?php echo $subpackage['subPackageID']; ?>">
                                <?php echo ucfirst(str_replace('_', ' ', $subpackage['duration'])); ?> - <?php echo number_format($subpackage['price'], 2); ?>/-
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="submit">Next</button>
            <?php else: ?>
                <p>No subpackages available for this package.</p>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
