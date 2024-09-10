<?php
session_start();
include '../../connection.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize inputs
    $trainerID = $_POST['trainerID'];
    $timeslotID = $_POST['timeslot'];
    $availableDate = $_POST['date'];
    $sessionType = $_POST['session_type'];

    // Set session status based on session type
    $sessionStatus = ($sessionType === 'private') ? 'Not Booked' : 'Active';

    // Check if a record already exists with the same trainerID, timeslotID, and availableDate
    $checkQuery = "SELECT COUNT(*) as count FROM trainingschedules WHERE trainerID = ? AND timeslotID = ? AND availableDate = ?";
    $stmt = $con->prepare($checkQuery);
    $stmt->bind_param("iis", $trainerID, $timeslotID, $availableDate);
    $stmt->execute();
    $result = $stmt->get_result();
    $count = $result->fetch_assoc()['count'];

    if ($count > 0) {
        $_SESSION['error_message'] = 'Schedule already exists for the selected timeslot and date.';
        header("Location: addTrainerScheduleForm.php?trainerID=$trainerID");
        exit();
    }

    // Check if there's aalready a session for the same time on weekdays
    if ($availableDate == 'monday' || $availableDate == 'tuesday' || $availableDate == 'wednesday' || $availableDate == 'thursday'
    || $availableDate == 'friday') {
        $checkWeekdaysQuery = "SELECT COUNT(*) as count FROM trainingschedules WHERE trainerID = ? AND timeslotID = ? AND availableDate = 'weekdays'";
        $stmt = $con->prepare($checkWeekdaysQuery);
        $stmt->bind_param("ii", $trainerID, $timeslotID);
        $stmt->execute();
        $result = $stmt->get_result();
        $countWeekdays = $result->fetch_assoc()['count'];

        if ($countWeekdays > 0) {
            $_SESSION['error_message'] = 'There is already a session scheduled for the same timeslot on weekdays.';
            header("Location: ../viewTrainerSchedule.php?trainerID=$trainerID");
            exit();
        }
    }

    // Insert new schedule into trainingschedules table
    $insertQuery = "INSERT INTO trainingschedules (trainerID, timeslotID, availableDate, sessionType, sessionStatus) VALUES (?, ?, ?, ?, ?)";
    $stmt = $con->prepare($insertQuery);
    $stmt->bind_param("iisss", $trainerID, $timeslotID, $availableDate, $sessionType, $sessionStatus);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = 'Trainer schedule added successfully!';
        header("Location: ../viewTrainerSchedule.php?trainerID=$trainerID");
        exit();
    } else {
        $_SESSION['error_message'] = 'Failed to add trainer schedule. Please try again.';
        header("Location: ../viewTrainerSchedule.php?trainerID=$trainerID");
        exit();
    }

} else {
    $_SESSION['error_message'] = 'Invalid request method.';
    header("Location: ../viewTrainerSchedule.php?trainerID=$trainerID");
    exit();
}
?>
