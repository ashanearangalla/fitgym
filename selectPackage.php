<?php
include 'connection.php';

$sql = "SELECT p.packageID, p.packageName, p.packageType, s.duration, s.price 
        FROM packages p 
        JOIN subpackages s ON p.packageID = s.packageID";
$result = $con->query($sql);

$packages = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $packages[$row['packageID']]['packageID'] = $row['packageID'];
        $packages[$row['packageID']]['packageName'] = $row['packageName'];
        $packages[$row['packageID']]['packageType'] = $row['packageType'];
        $packages[$row['packageID']]['subPackages'][] = [
            'duration' => $row['duration'],
            'price' => $row['price']
        ];
    }
} else {
    echo "0 results";
}
$con->close();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membership Plans - FITNESS WORLD</title>
    <link rel="stylesheet" href="assets/css/stylesheetmain.css">
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
        <h1>Membership Packages</h1>
        <p>Choose the package that suits you best and start your fitness journey with us!</p>
        <div class="plans">
            <?php foreach ($packages as $package): ?>
                <div class="plan-card">
                    <h2><?php echo $package['packageName']; ?> Membership</h2>
                    <ul>
                        <?php foreach ($package['subPackages'] as $subPackage): ?>
                            <li><?php echo ucfirst(str_replace('_', ' ', $subPackage['duration'])); ?>: <?php echo number_format($subPackage['price'], 2); ?>/-</li>
                        <?php endforeach; ?>
                    </ul>
                    <a href="selectDuration.php?packageID=<?php echo $package['packageID'] ?>"><button>Select</button></a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="js/script.js"></script>
</body>
</html>
