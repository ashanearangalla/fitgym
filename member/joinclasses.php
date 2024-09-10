<?php
session_start();
include '../connection.php';

// Check if the user is logged in
if (!isset($_SESSION['user']['memberID'])) {
    header("Location: login.php");
    exit();
}

$memberID = $_SESSION['user']['memberID'];

// Fetch available classes
$sql = "SELECT c.classID, c.className
        FROM classes c
        LEFT JOIN classenrollments ce ON c.classID = ce.classID AND ce.memberID = ?
        WHERE ce.classEnrollmentID IS NULL";

$stmt = $con->prepare($sql);
$stmt->bind_param("i", $memberID);
$stmt->execute();
$result = $stmt->get_result();

$classes = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $classes[] = $row;
    }
}

// Handle class enrollment
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $classID = $_POST['classID'];

    // Insert into classenrollments table
    $insertQuery = "INSERT INTO classenrollments (classID, memberID) VALUES (?, ?)";
    $stmt = $con->prepare($insertQuery);
    $stmt->bind_param("ii", $classID, $memberID);
    if ($stmt->execute()) {
        $_SESSION['success_message'] = 'Successfully enrolled in the class!';
        header("Location: myclasses.php");
        exit();
    } else {
        echo "Error enrolling in class: " . $stmt->error;
        exit();
    }
}

$con->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Classes</title>
    <link rel="stylesheet" href="../assets/css/stylesheetmain.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
       
        .profile-details select,
        .profile-details button {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
    </style>
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
            <h2>Join Classes</h2>
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
                <form action="joinclasses.php" method="post">
                    <label for="classID">Select Class:</label>
                    <select style="margin-bottom: 50px;" name="classID" id="classID" required>
                        <option value="">Select a class</option>
                        <?php foreach ($classes as $class) : ?>
                            <option value="<?php echo htmlspecialchars($class['classID']); ?>"><?php echo htmlspecialchars($class['className']); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit">Join Class</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>