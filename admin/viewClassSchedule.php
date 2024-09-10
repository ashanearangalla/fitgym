<?php
session_start();

// Database connection
include('../connection.php');

// Handle deletion
if (isset($_GET['scheduleID'])) {
    $classScheduleID = $_GET['scheduleID'];
    
    // Prepare and execute deletion query
    $deleteQuery = "DELETE FROM classschedule WHERE classScheduleID = ?";
    $stmt = $con->prepare($deleteQuery);
    $stmt->bind_param('i', $classScheduleID);
    
    if ($stmt->execute()) {
        $_SESSION['success_message'] = 'Schedule deleted successfully!';
    } else {
        $_SESSION['error_message'] = 'Error deleting schedule: ' . $stmt->error;
    }

    header("Location: viewClass.php?classID=" . $_GET['classID']);
    exit();
}

// Fetch class schedule details including timeslot information
$classID = $_GET['classID'] ?? null;
if (!$classID) {
    $_SESSION['error_message'] = 'Class ID not provided.';
    header("Location: viewClasses.php");
    exit();
}

// SQL query to order by day of the week (assuming day is stored as a string)
$query = "SELECT classschedule.classScheduleID, classschedule.day, timeslots.startTime, timeslots.endTime 
          FROM classschedule 
          INNER JOIN timeslots ON classschedule.timeslotID = timeslots.timeslotID
          WHERE classschedule.classID = ?
          ORDER BY FIELD(classschedule.day, 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat')";
$stmt = $con->prepare($query);
$stmt->bind_param('i', $classID);
$stmt->execute();
$result = $stmt->get_result();
$classSchedules = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Class Schedule</title>
    <link rel="stylesheet" href="../assets/css/styleadmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Add any additional styles specific to viewSchedule.php */
    </style>
</head>
<body>
    <div class="admin-container">
        <?php include("sidemenu.php"); ?>

        <div class="content">
            <div class="content-header">
                <h1>Class Schedule</h1>
            </div>
            
            <div class="content-section">
                
                <table class="event-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Day</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($classSchedules) {
                            $count = 1;
                            foreach ($classSchedules as $schedule) {
                                echo "<tr>
                                        <td>{$count}</td>
                                        <td>{$schedule['day']}</td>
                                        <td>{$schedule['startTime']}</td>
                                        <td>{$schedule['endTime']}</td>
                                        <td>
                                            <a href='newClassSchedule.php?classID={$classID}&classScheduleID={$schedule['classScheduleID']}' class='edit-button'>Edit</a>
                                            <a href='viewClassSchedule.php?scheduleID={$schedule['classScheduleID']}' class='delete-button' onclick='return confirm(\"Are you sure you want to delete this schedule?\")'>Delete</a>
                                        </td>
                                    </tr>";
                                $count++;
                            }
                        } else {
                            echo "<tr><td colspan='5'>No schedule available for this class.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="bottom-box">
                <a href="newClassSchedule.php?classID=<?php echo $classID; ?>"><button class="button-main">Add Class Schedule</button></a>
            </div>
        </div>
    </div>
    <script src="../assets/js/admin.js"></script>
</body>
</html>
