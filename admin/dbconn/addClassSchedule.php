<?php
session_start();
include '../../connection.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $classID = $_POST['classID'];
    $classScheduleID = $_POST['classScheduleID'] ?? null;
    $timeslotID = $_POST['timeslotID'];
    $day = $_POST['day'];

    if ($classScheduleID) {
        // Update existing class schedule
        $query = "UPDATE classschedule SET timeslotID = ?, day = ? WHERE classScheduleID = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('isi', $timeslotID, $day, $classScheduleID);
    } else {
        // Insert new class schedule
        $query = "INSERT INTO classschedule (classID, timeslotID, day) VALUES (?, ?, ?)";
        $stmt = $con->prepare($query);
        $stmt->bind_param('iis', $classID, $timeslotID, $day);
    }

    if ($stmt->execute()) {
        $_SESSION['success_message'] = $classScheduleID ? 'Class schedule updated successfully!' : 'Class schedule added successfully!';
    } else {
        $_SESSION['error_message'] = 'Error saving class schedule: ' . $stmt->error;
    }

    header("Location: ../viewClassSchedule.php?classID=" . $classID);
    exit();
} else {
    header("Location: ../viewClasses.php"); // Redirect to the form if accessed directly
    exit();
}
?>
