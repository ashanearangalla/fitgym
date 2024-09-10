<?php
session_start();
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['scheduleID'])) {
        $scheduleID = $_POST['scheduleID'];
        $enrollmentID = $_SESSION['enrollmentID'];

        // Update the training schedule
        $updateQuery = "UPDATE trainingschedules SET enrollmentID = ?, sessionStatus = 'Pending' WHERE scheduleID = ?";
        $stmt = $con->prepare($updateQuery);
        $stmt->bind_param('ii', $enrollmentID, $scheduleID);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $_SESSION['success_message'] = 'Session confirmed successfully!';
            header("Location: login.php");
            exit();
        } else {
            $_SESSION['error_message'] = 'Failed to confirm the session. Please try again.';
            header("Location: requestSessions.php");
            exit();
        }
    } else {
        $_SESSION['error_message'] = 'Invalid request. Schedule ID is required.';
        header("Location: requestSessions.php");
        exit();
    }
} else {
    header("Location: requestSessions.php");
    exit();
}
?>