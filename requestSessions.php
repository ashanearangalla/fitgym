<?php
session_start();
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['trainerID'])) {
        $trainerID = $_POST['trainerID'];
        $enrollmentIDID = $_POST['enrollmentID'];
    } else {
        $_SESSION['error_message'] = 'Invalid request. Trainer ID is required.';
        header("Location: selectTrainer.php");
        exit();
    }
} else {
    header("Location: selectTrainer.php");
    exit();
}

// Fetch private sessions for the selected trainer
$sql = "SELECT ts.scheduleID, ts.availableDate, t.startTime, t.endTime, ts.sessionStatus
        FROM trainingschedules ts
        INNER JOIN timeslots t ON ts.timeslotID = t.timeslotID
        WHERE ts.trainerID = ? AND ts.sessionType = 'private' AND ts.sessionStatus = 'Not Booked'";

$stmt = $con->prepare($sql);
$stmt->bind_param("i", $trainerID);
$stmt->execute();
$result = $stmt->get_result();

$sessions = $result->fetch_all(MYSQLI_ASSOC);

$con->close();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Session - FITNESS WORLD</title>
    <link rel="stylesheet" href="assets/css/stylemember.css">
    <style>
        
.duration-options {
    margin-top: 50px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
    margin-bottom: 30px;
}

.duration-option {
    display: flex;
    align-items: center;
    flex-direction: column;
    gap: 0.5rem;
    background-color: rgba(255, 204, 0, 0.1);
    border: 1px solid #FFCC00;
    border-radius: 8px;
    padding: 1rem;
    width: 100%;
    max-width: 400px;
    transition: background-color 0.3s;
}

.duration-option:hover {
    background-color: rgba(255, 204, 0, 0.2);
}

.duration-option input[type="radio"] {
    accent-color: #FFCC00;
    width: 1.2rem;
    height: 1.2rem;
}

.duration-option label {
    font-size: 1rem;
    color: #ddd;
}

    </style>
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
        <h1>Select Private Session</h1>
        <form action="confirmSession.php" method="post">
            <input type="hidden" name="trainerID" value="<?php echo htmlspecialchars($trainerID); ?>">
            <input type="hidden" name="enrollmentID" value="<?php echo htmlspecialchars($enrollmentID); ?>">
            <?php if (!empty($sessions)): ?>
                <div class="duration-options">
                    <?php foreach ($sessions as $session): ?>
                        <div class="duration-option">
                            <input type="radio" id="session_<?php echo $session['scheduleID']; ?>" name="scheduleID" value="<?php echo $session['scheduleID']; ?>" required>
                            <label for="session_<?php echo $session['scheduleID']; ?>">
                                <p>Date: <?php echo htmlspecialchars($session['availableDate']); ?></p>
                                <p>Time: <?php echo htmlspecialchars(date('h:i A', strtotime($session['startTime'])) . ' - ' . date('h:i A', strtotime($session['endTime']))); ?></p>
                               
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="submit">Next</button>
            <?php else: ?>
                <p>No private sessions available for this trainer.</p>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>