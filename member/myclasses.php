<?php
session_start();
include '../connection.php';

// Assuming the user is logged in and their memberID is stored in the session
$memberID = $_SESSION['user']['memberID'];

// Fetch enrolled classes
$sql = "SELECT ce.classEnrollmentID, c.className, cs.day, ts.startTime, ts.endTime
        FROM classenrollments ce
        INNER JOIN classes c ON ce.classID = c.classID
        INNER JOIN classschedule cs ON c.classID = cs.classID
        INNER JOIN timeslots ts ON cs.timeslotID = ts.timeslotID
        WHERE ce.memberID = ?
        ORDER BY 
            CASE
                WHEN cs.day = 'Mon' THEN 1
                WHEN cs.day = 'Tue' THEN 2
                WHEN cs.day = 'Wed' THEN 3
                WHEN cs.day = 'Thu' THEN 4
                WHEN cs.day = 'Fri' THEN 5
                WHEN cs.day = 'Sat' THEN 6
            END";

$stmt = $con->prepare($sql);
$stmt->bind_param("i", $memberID);
$stmt->execute();
$result = $stmt->get_result();

$enrolledClasses = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $enrolledClasses[] = $row;
    }
} else {
    $noClasses = true;
}

$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Classes</title>
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
        .no-classes {
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
        <h2>My Classes</h2>
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
            <div style="width: 100%;">
            <a href="joinclasses.php" style="margin-left:100px; float: left; margin-bottom: 15px; padding: 10px; background-color: #333; color: white; text-decoration: none; border-radius: 4px;">Join Classes</a>

            </div>
            <table>
                <tr>
                    <th>Class Name</th>
                    <th>Day</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                </tr>
                <?php if (isset($noClasses) && $noClasses): ?>
                    <tr>
                        <td style="background-color: #6b6b6b; color: white;" colspan="4" class="no-classes">No enrolled classes found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($enrolledClasses as $class): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($class['className']); ?></td>
                        <td><?php echo htmlspecialchars($class['day']); ?></td>
                        <td><?php echo date("g:i A", strtotime($class['startTime'])); ?></td>
                        <td><?php echo date("g:i A", strtotime($class['endTime'])); ?></td>
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