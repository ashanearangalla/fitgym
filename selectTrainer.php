<?php
session_start();
include 'connection.php';

if (isset($_SESSION['enrollmentID'])) {
    $enrollmentID = $_SESSION['enrollmentID'];
} else {
    $_SESSION['error_message'] = 'Invalid request. Enrollment ID is required.';
    header("Location: registration.php");
    exit();
}

// Fetch trainers from the database
$query = "SELECT * FROM trainers INNER JOIN users on trainers.userID = users.userID";
$result = $con->query($query);
$trainers = $result->fetch_all(MYSQLI_ASSOC);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Trainer - FITNESS WORLD</title>
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
        <h1>Select Trainer</h1>
        <form action="requestSessions.php" method="post">
            <input type="hidden" name="enrollmentID" value="<?php echo $enrollmentID; ?>">
            
            <?php if (!empty($trainers)): ?>
                <div class="trainer-options trainer-container">
                    <?php foreach ($trainers as $trainer): ?>
                        <div class="trainer-card">
                            <input type="radio" id="trainer_<?php echo $trainer['trainerID']; ?>" name="trainerID" value="<?php echo $trainer['trainerID']; ?>" required>
                            <label for="trainer_<?php echo $trainer['trainerID']; ?>">
                                <img src="<?php echo htmlspecialchars($trainer['imageurl']); ?>" alt="<?php echo htmlspecialchars($trainer['name']); ?>">
                                <p><?php echo htmlspecialchars($trainer['name']); ?> - <?php echo htmlspecialchars($trainer['title']); ?></p>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button style="margin-top: 20px;" type="submit">Next</button>
            <?php else: ?>
                <p>No trainers available.</p>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>