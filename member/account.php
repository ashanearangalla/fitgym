<?php
session_start();
include '../connection.php';

// Assuming the user is logged in and their memberID is stored in the session
$memberID = $_SESSION['user']['memberID'];

// Fetch user details
$sql = "SELECT u.userID, u.name, u.email, u.contactNo, m.dob, p.packageName, p.packageType, me.startDate, me.endDate, sp.duration
        FROM users u
        INNER JOIN members m ON u.userID = m.userID
        INNER JOIN memberenrollments me ON m.memberID = me.memberID
        INNER JOIN subpackages sp ON me.subPackageID = sp.subPackageID
        INNER JOIN packages p ON sp.packageID = p.packageID
        WHERE m.memberID = ?";

$stmt = $con->prepare($sql);
$stmt->bind_param("i", $memberID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
} else {
    echo "User details not found.";
    exit;
}

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contactNo = $_POST['contactNo'];
    $dob = $_POST['dob'];

    // Update user details
    $updateQuery = "UPDATE users SET name=?, email=?, contactNo=? WHERE userID=?";
    $stmt = $con->prepare($updateQuery);
    $stmt->bind_param("sssi", $name, $email, $contactNo, $user['userID']);
    if (!$stmt->execute()) {
        echo "Error updating user: " . $stmt->error;
        exit();
    }

    // Update member details
    $updateQuery = "UPDATE members SET dob=? WHERE memberID=?";
    $stmt = $con->prepare($updateQuery);
    $stmt->bind_param("si", $dob, $memberID);
    if (!$stmt->execute()) {
        echo "Error updating member: " . $stmt->error;
        exit();
    }

    $_SESSION['success_message'] = 'Profile updated successfully!';
    header("Location: account.php");
    exit();
}

$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="../assets/css/stylesheetmain.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<header>
    <h1>FITNESS WORLD</h1>
    <nav>
        <a href="../logout.php">Logout</a>
    </nav>
</header>
<div class="account-content">
    <div class="heading">
        <h2>My Profile</h2>
    </div>
    <div class="profile-card">
        <div class="profile-box">
            <img id="profilePicture" src="../assets/images/icon.jpg" alt="Profile Picture">
            <div class="links">
                <a href="account.php">My Account</a>
                <a href="mysessions.php">My Sessions</a>
                <a href="myclasses.php">My Classes</a>
            </div>
        </div>
        <div class="profile-details">
            <form action="account.php" method="post">
                <p><strong>Name:</strong> <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>"></p>
                <p><strong>Email:</strong> <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>"></p>
                <p><strong>Contact No:</strong> <input type="tel" name="contactNo" value="<?php echo htmlspecialchars($user['contactNo']); ?>"></p>
                <p><strong>Date of Birth:</strong> <input type="date" name="dob" value="<?php echo htmlspecialchars($user['dob']); ?>"></p>
                <div class="changeSubmit-btn">
                    <input  type="submit" value="Update">
                </div>
            </form>
            <div class="package-details">
                <h3>Current Package</h3>
                <p><strong>Package Name:</strong> <?php echo htmlspecialchars($user['packageName']); ?></p>
                <p><strong>Duration:</strong> <?php echo htmlspecialchars($user['duration']); ?></p>
                <p><strong>Start Date:</strong> <?php echo htmlspecialchars($user['startDate']); ?></p>
                <p><strong>End Date:</strong> <?php echo htmlspecialchars($user['endDate']); ?></p>
            </div>
        </div>
    </div>
</div>
<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('profilePicture');
            output.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
</body>
</html>