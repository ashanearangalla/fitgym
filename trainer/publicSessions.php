<?php
session_start();
include '../connection.php';

// Assuming the trainer is logged in and their ID is stored in the session
$trainerID = $_SESSION['user']['trainerID'];

$sql = "SELECT ts.scheduleID, ts.availableDate, t.startTime, t.endTime
        FROM trainingschedules ts
        INNER JOIN timeslots t ON ts.timeslotID = t.timeslotID
        WHERE ts.trainerID = ? AND ts.sessionType = 'public'";

$stmt = $con->prepare($sql);
$stmt->bind_param("i", $trainerID);
$stmt->execute();
$result = $stmt->get_result();

$sessions = $result->fetch_all(MYSQLI_ASSOC);

$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainer Classes</title>
    <link rel="stylesheet" href="../assets/css/styleaccount.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>s
    <?php include("trainerSidemenu.php"); ?>
    <div class="content">
        <div class="heading">
            <h2>My Public Sessions</h2>
        </div>
        <table>
            <tr>
                <th>No</th>
                <th>Date</th>
                <th>Start Time</th>
                <th>End Time</th>
            </tr>
            <?php 
            $index = 1;
            foreach ($sessions as $session): 
            ?>
            <tr>
                <td><?php echo htmlspecialchars($index); ?></td>
                <td><?php echo htmlspecialchars($session['availableDate']); ?></td>
                <td><?php echo htmlspecialchars(date('h:i A', strtotime($session['startTime']))); ?></td>
                <td><?php echo htmlspecialchars(date('h:i A', strtotime($session['endTime']))); ?></td>
            </tr>
            <?php 
            $index++;
            endforeach; 
            ?>
        </table>
    </div>
</body>
</html>
