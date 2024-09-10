<?php
session_start();
include '../connection.php'; // Include your database connection file

// Fetch timeslots from database
$fetchTimeslotsQuery = "SELECT timeslotID, startTime, endTime FROM timeslots";
$stmt = $con->prepare($fetchTimeslotsQuery);
$stmt->execute();
$timeslots = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Get trainerID from the URL parameter
if (isset($_GET['trainerID'])) {
    $trainerID = $_GET['trainerID'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debra Admin Panel - Add Trainer Schedule</title>
    <link rel="stylesheet" href="../assets/css/styleadmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="admin-container">
        <?php include("sidemenu.php"); ?>

        <div class="content">
            <div class="content-header">
                <h1>Add Trainer Schedule</h1>
            </div>
            
            <div  id="create-trainer-schedule" class="content-section-form">
                <form  id="trainer-schedule-form" action="dbconn/addTrainerSchedule.php" method="POST">
                    <div class="form-group">
                        <div  style="width: 500px;" class="col">
                            <label for="timeslot">Timeslot</label>
                            <select  id="timeslot" name="timeslot" required>
                                
                                <?php foreach ($timeslots as $timeslot): ?>
                                    <option value="<?php echo $timeslot['timeslotID']; ?>">
                                        <?php echo $timeslot['startTime'] . ' - ' . $timeslot['endTime']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div  style="width: 500px;" class="col">
                            <label for="date">Date</label>
                            <select id="date" name="date" required>
                                
                                <option value="weekdays">Weekdays</option>
                                <option value="monday">Monday</option>
                                <option value="tuesday">Tuesday</option>
                                <option value="wednesday">Wednesday</option>
                                <option value="thursday">Thursday</option>
                                <option value="friday">Friday</option>
                                <option value="saturday">Saturday</option>
                            </select>
                        </div>
                    </div>
                    <div  class="form-group">
                        <div  style="width: 500px;" class="col">
                            <label for="session-type">Session Type</label>
                            <select  id="session-type" name="session_type" required>
                               
                                <option value="public">Public</option>
                                <option value="private">Private</option>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="trainerID" value="<?php echo isset($trainerID) ? $trainerID : ''; ?>">
                    <button type="submit" class="submit-button-form">Add Trainer Schedule</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
