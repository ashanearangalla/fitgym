<?php
session_start();
include '../connection.php';

// Assuming the user is logged in and their memberID is stored in the session
$memberID = $_SESSION['user']['memberID'];

// Fetch training sessions
$sql = "SELECT ts.scheduleID, u.name, t.title AS trainerName, ts.availableDate, tm.startTime, tm.endTime, ts.sessionStatus
        FROM trainingschedules ts
        INNER JOIN memberenrollments me ON ts.enrollmentID = me.enrollmentID
        INNER JOIN timeslots tm ON ts.timeslotID = tm.timeslotID
        INNER JOIN trainers t ON ts.trainerID = t.trainerID
        INNER JOIN users u ON t.userID = u.userID
        WHERE me.memberID = ?
        ORDER BY ts.availableDate, tm.startTime";

$stmt = $con->prepare($sql);
$stmt->bind_param("i", $memberID);
$stmt->execute();
$result = $stmt->get_result();

$mySessions = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $mySessions[] = $row;
    }
} else {
    $noSessionsFound = true;
}

$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Sessions</title>
    <link rel="stylesheet" href="../assets/css/stylesheetmain.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-left: 100px;
            margin-right: 100px;
        }
        table, th, td {
            border: 1px solid #bdc3c7;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #333;
            color: white;
        }
        tr {
            background-color:#6b6b6b;
        }
        .no-sessions {
            text-align: center;
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
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
        <h2>My Sessions</h2>
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
        <div class="profile-details-table">
            <table>
                <tr>
                    <th>Trainer</th>
                    <th>Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Status</th>
                </tr>
                <?php if (isset($noSessionsFound) && $noSessionsFound): ?>
                    <tr>
                        <td style="background-color: #6b6b6b; color: white;" colspan="5" class="no-sessions">No sessions found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($mySessions as $session): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($session['name']); ?></td>
                        <td><?php echo htmlspecialchars($session['availableDate']); ?></td>
                        <td><?php echo date("g:i A", strtotime($session['startTime'])); ?></td>
                        <td><?php echo date("g:i A", strtotime($session['endTime'])); ?></td>
                        <td><?php echo htmlspecialchars($session['sessionStatus']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </table>
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