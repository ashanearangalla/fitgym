<?php
session_start();
include '../connection.php'; // Include your database connection file

$classID = '';
$classScheduleID = '';
$timeslotID = '';
$day = '';

// Fetch available timeslots
$query = "SELECT timeslotID, startTime, endTime FROM timeslots";
$result = $con->query($query);
$timeslots = $result->fetch_all(MYSQLI_ASSOC);

// Check if classID and/or classScheduleID are provided for editing
if (isset($_GET['classID'])) {
    $classID = $_GET['classID'];
}
if (isset($_GET['classScheduleID'])) {
    $classScheduleID = $_GET['classScheduleID'];
    
    // Fetch class schedule details for editing
    $query = "SELECT timeslotID, day FROM classschedule WHERE classScheduleID = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('i', $classScheduleID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $schedule = $result->fetch_assoc();
        $timeslotID = $schedule['timeslotID'];
        $day = $schedule['day'];
    } else {
        $_SESSION['error_message'] = 'Class schedule not found.';
        header("Location: viewClasses.php");
        exit();
    }
} else {
    if (!$classID) {
        $_SESSION['error_message'] = 'Class ID not provided.';
        header("Location: viewClasses.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debra Admin Panel - <?php echo $classScheduleID ? 'Edit' : 'Add'; ?> Class Schedule</title>
    <link rel="stylesheet" href="../assets/css/styleadmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="admin-container">
        <?php include("sidemenu.php"); ?>

        <div class="content">
            <div class="content-header">
                <h1><?php echo $classScheduleID ? 'Edit' : 'Add'; ?> Class Schedule</h1>
            </div>
            
            <div id="create-class-schedule" class="content-section-form">
                <form id="class-schedule-form" action="dbconn/addClassSchedule.php" method="POST">
                    <input type="hidden" name="classID" value="<?php echo $classID; ?>">
                    <input type="hidden" name="classScheduleID" value="<?php echo $classScheduleID; ?>">
                    <div class="form-group">
                        <div style="width: 500px;" class="col">
                            <label for="timeslotID">Timeslot</label>
                            <select id="timeslotID" name="timeslotID" required>
                                <?php foreach ($timeslots as $timeslot): ?>
                                    <option value="<?php echo $timeslot['timeslotID']; ?>" <?php echo ($timeslotID == $timeslot['timeslotID']) ? 'selected' : ''; ?>>
                                        <?php echo $timeslot['startTime'] . ' - ' . $timeslot['endTime']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div style="width: 500px;" class="col">
                            <label for="day">Day</label>
                            <select id="day" name="day" required>
                                <option value="Mon" <?php echo ($day == 'Mon') ? 'selected' : ''; ?>>Monday</option>
                                <option value="Tue" <?php echo ($day == 'Tue') ? 'selected' : ''; ?>>Tuesday</option>
                                <option value="Wed" <?php echo ($day == 'Wed') ? 'selected' : ''; ?>>Wednesday</option>
                                <option value="Thu" <?php echo ($day == 'Thu') ? 'selected' : ''; ?>>Thursday</option>
                                <option value="Fri" <?php echo ($day == 'Fri') ? 'selected' : ''; ?>>Friday</option>
                                <option value="Sat" <?php echo ($day == 'Sat') ? 'selected' : ''; ?>>Saturday</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="submit-button-form"><?php echo $classScheduleID ? 'Update' : 'Add'; ?> Class Schedule</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
