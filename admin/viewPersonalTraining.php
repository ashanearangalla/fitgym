<?php
session_start();

// Database connection
include('../connection.php');

// Fetch private personal training schedules
$query = "SELECT ts.scheduleID, users.name AS trainerName, ts.availableDate, ts.sessionType, ts.sessionStatus, 
                 timeslots.startTime, timeslots.endTime, memberUsers.name AS memberName
          FROM trainingschedules ts
          INNER JOIN trainers ON ts.trainerID = trainers.trainerID
          INNER JOIN users ON trainers.userID = users.userID
          INNER JOIN timeslots ON ts.timeslotID = timeslots.timeslotID
          LEFT JOIN memberenrollments ON ts.enrollmentID = memberenrollments.enrollmentID
          LEFT JOIN members ON memberenrollments.memberID = members.memberID
          LEFT JOIN users AS memberUsers ON members.userID = memberUsers.userID
          WHERE ts.sessionType = 'private'";
$result = mysqli_query($con, $query);
$schedules = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Handle cancel request
if (isset($_POST['cancel'])) {
    $scheduleID = $_POST['scheduleID'];
    
    // Update session status to "Cancelled"
    $cancelQuery = "UPDATE trainingschedules SET sessionStatus = 'Cancelled' WHERE scheduleID = ?";
    $stmt = $con->prepare($cancelQuery);
    $stmt->bind_param('i', $scheduleID);
    
    if ($stmt->execute()) {
        echo "<script>alert('Training schedule cancelled successfully'); window.location.href='viewPersonalTraining.php';</script>";
    } else {
        echo "<script>alert('Error cancelling training schedule'); window.location.href='viewPersonalTraining.php';</script>";
    }
}

// Handle delete request
if (isset($_POST['delete'])) {
    $scheduleID = $_POST['scheduleID'];
    
    // Delete training schedule query
    $deleteQuery = "DELETE FROM trainingschedules WHERE scheduleID = ?";
    $stmt = $con->prepare($deleteQuery);
    $stmt->bind_param('i', $scheduleID);
    
    if ($stmt->execute()) {
        echo "<script>alert('Training schedule deleted successfully'); window.location.href='viewPersonalTraining.php';</script>";
    } else {
        echo "<script>alert('Error deleting training schedule'); window.location.href='viewPersonalTraining.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debra Admin Panel - Personal Training Schedules</title>
    <link rel="stylesheet" href="../assets/css/styleadmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="admin-container">
        <?php include("sidemenu.php"); ?>

        <div class="content">
            <div class="content-header">
                <h1>Personal Training Schedules</h1>
            </div>
            
            <div class="content-section">
                <table class="event-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Trainer Name</th>
                            <th>Available Date</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Session Status</th>
                            <th>Member Name</th>
                            
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($schedules) {
                            $count = 1;
                            foreach ($schedules as $schedule) {
                                echo "<tr>
                                        <td>{$count}</td>
                                        <td>{$schedule['trainerName']}</td>
                                        <td>{$schedule['availableDate']}</td>
                                        <td>{$schedule['startTime']}</td>
                                        <td>{$schedule['endTime']}</td>
                                        <td>{$schedule['sessionStatus']}</td>
                                        <td>{$schedule['memberName']}</td>
                                        
                                        <td>
                                            <form method='post' action='' style='display:inline-block;'>
                                                <input type='hidden'   name='scheduleID' value='{$schedule['scheduleID']}'>
                                                <button type='submit'  name='cancel' class='edit-button'>Cancel</button>
                                            </form>
                                            <form method='post' action='' style='display:inline-block;'>
                                                <input type='hidden' name='scheduleID' value='{$schedule['scheduleID']}'>
                                                <button type='submit' name='delete' class='delete-button'>Delete</button>
                                            </form>
                                        </td>
                                    </tr>";
                                $count++;
                            }
                        } else {
                            echo "<tr><td colspan='8'>No data available</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="bottom-box">
               
            </div>
        </div>
    </div>
    <script src="../assets/js/admin.js"></script>
</body>
</html>