<?php
session_start();

// Database connection
include('../connection.php');

// Handle delete request
if (isset($_POST['delete'])) {
    $scheduleID = $_POST['scheduleID'];
    $trainerID = $_POST['trainerID'];
    
    // Delete schedule query
    $deleteQuery = "DELETE FROM trainingschedules WHERE scheduleID = ?";
    $stmt = $con->prepare($deleteQuery);
    $stmt->bind_param('i', $scheduleID);
    
    if ($stmt->execute()) {
        echo "<script>alert('Schedule deleted successfully'); window.location.href='viewTrainerSchedule.php?trainerID=$trainerID';</script>";
    } else {
        echo "<script>alert('Error deleting schedule'); window.location.href='viewTrainerSchedule.php?trainerID=$trainerID';</script>";
    }
    exit;
}

// Fetch trainer ID from the GET request
$trainerID = $_GET['trainerID'];

// Fetch trainer schedule
$query = "SELECT trainingschedules.scheduleID, trainingschedules.availableDate, trainingschedules.sessionType, timeslots.startTime, timeslots.endTime 
          FROM trainingschedules 
          INNER JOIN timeslots ON trainingschedules.timeSlotID = timeslots.timeSlotID 
          WHERE trainingschedules.trainerID = ?
          ORDER BY trainingschedules.scheduleID ASC";
$stmt = $con->prepare($query);
$stmt->bind_param('i', $trainerID);
$stmt->execute();
$result = $stmt->get_result();
$schedules = $result->fetch_all(MYSQLI_ASSOC);

$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debra Admin Panel - Trainer Schedule</title>
    <link rel="stylesheet" href="../assets/css/styleadmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="admin-container">
        <?php include("sidemenu.php"); ?>

        <div class="content">
            <div class="content-header">
                <h1>Trainer Schedule</h1>
            </div>
            
            <div class="content-section">
                <table class="event-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Date</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Type</th>
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
                                        <td>{$schedule['availableDate']}</td>
                                        <td>{$schedule['startTime']}</td>
                                        <td>{$schedule['endTime']}</td>
                                        <td>{$schedule['sessionType']}</td>
                                        <td>
                                            <a href='editSchedule.php?scheduleID={$schedule['scheduleID']}' class='edit-button'>Edit</a>
                                            <form method='post' action='' style='display:inline-block;'>
                                                <input type='hidden' name='scheduleID' value='{$schedule['scheduleID']}'>
                                                <input type='hidden' name='trainerID' value='{$trainerID}'>
                                                <button type='submit' name='delete' class='delete-button'>Delete</button>
                                            </form>
                                        </td>
                                    </tr>";
                                $count++;
                            }
                        } else {
                            echo "<tr><td colspan='6'>No data available</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="bottom-box">
                <a href="newTrainerSchedule.php?trainerID=<?php echo $trainerID?>"><button class="button-main">Add Trainer Schedule</button></a>
            </div>
        </div>
    </div>
    <script src="../assets/js/admin.js"></script>
</body>
</html>