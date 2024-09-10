<?php
session_start();
include '../connection.php';

// Assuming the trainer is logged in and their ID is stored in the session
$trainerID = $_SESSION['user']['trainerID'];

// Fetch sessions
$sql = "SELECT ts.scheduleID, ts.availableDate, t.startTime, t.endTime, u.name AS memberName, ts.sessionStatus, me.enrollmentID
        FROM trainingschedules ts
        INNER JOIN timeslots t ON ts.timeslotID = t.timeslotID
        INNER JOIN memberenrollments me ON ts.enrollmentID = me.enrollmentID
        INNER JOIN members m ON me.memberID = m.memberID
        INNER JOIN users u ON m.userID = u.userID
        WHERE ts.trainerID = ? AND ts.sessionType = 'private' AND (ts.sessionStatus = 'Booked' OR ts.sessionStatus = 'Pending')";

$stmt = $con->prepare($sql);
$stmt->bind_param("i", $trainerID);
$stmt->execute();
$result = $stmt->get_result();

$sessions = $result->fetch_all(MYSQLI_ASSOC);

// Handle actions
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['action']) && isset($_GET['scheduleID'])) {
        $action = $_GET['action'];
        $scheduleID = $_GET['scheduleID'];

        if ($action == 'cancel') {
            $updateQuery = "UPDATE trainingschedules SET sessionStatus = 'Not Booked', enrollmentID = NULL WHERE scheduleID = ?";
        } elseif ($action == 'confirm') {
            $updateQuery = "UPDATE trainingschedules SET sessionStatus = 'Booked' WHERE scheduleID = ?";
        }

        if (isset($updateQuery)) {
            $stmt = $con->prepare($updateQuery);
            $stmt->bind_param("i", $scheduleID);
            if ($stmt->execute()) {
                $_SESSION['success_message'] = 'Session updated successfully!';
                header("Location: privateSessions.php");
                exit();
            } else {
                echo "Error updating session: " . $stmt->error;
                exit();
            }
        }
    }
}

$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainer Private Sessions</title>
    <link rel="stylesheet" href="../assets/css/styleaccount.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .edit-button {
            font-size: 16px;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 5px 8px;
            cursor: pointer;
        }
        .confirm-button {
            background-color: #4CAF50; /* Green */
        }
        .cancel-button {
            background-color: #f44336; /* Red */
        }
        .confirmed-button {
            background-color: #d3d3d3; /* Grey */
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <?php include("trainerSidemenu.php"); ?>
    <div class="content">
        <div class="heading">
            <h2>Booked Private Sessions</h2>
        </div>
        <table>
            <tr>
                <th>No</th>
                <th>Date</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Member Name</th>
                <th>Session Status</th>
                <th>Action</th>
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
                <td><?php echo htmlspecialchars($session['memberName']); ?></td>
                <td><?php echo htmlspecialchars($session['sessionStatus']); ?></td>
                <td>
                    <?php if ($session['sessionStatus'] == 'Booked'): ?>
                        <button class="edit-button confirmed-button" disabled>Confirmed</button>
                    <?php else: ?>
                        <a href="?action=confirm&scheduleID=<?php echo htmlspecialchars($session['scheduleID']); ?>" onclick="return confirm('Are you sure you want to confirm this session?')" class="edit-button confirm-button">Confirm</a>
                        <a href="?action=cancel&scheduleID=<?php echo htmlspecialchars($session['scheduleID']); ?>" onclick="return confirm('Are you sure you want to cancel this session?')" class="edit-button cancel-button">Cancel</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php 
            $index++;
            endforeach; 
            ?>
        </table>
    </div>
</body>
</html>
