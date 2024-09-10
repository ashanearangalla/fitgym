<?php
session_start();
include '../../connection.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Common fields for both add and edit
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Encrypt the password
    $phone = $_POST['phone'];
    $healthConcerns = $_POST['healthConcerns'];
    $dob = $_POST['dob'];
    $joinDate = isset($_POST['join_date']) ? $_POST['join_date'] : date('Y-m-d'); // Use current date if not provided
    $role = 'Member';

    // If memberID is set, update existing member, otherwise insert new member
    if (isset($_GET['memberID'])) {
        // Edit existing member
        $memberID = $_GET['memberID'];
        $userID = $_GET['userID'];

        // Update users table (for email, password, phone, name)
        $userUpdateQuery = "UPDATE users SET email=?, password=?, contactNo=?, name=? WHERE userID=?";
        $stmt = $con->prepare($userUpdateQuery);
        $stmt->bind_param("ssssi", $email, $password, $phone, $name, $userID);
        if (!$stmt->execute()) {
            echo "Error updating user: " . $stmt->error;
            exit();
        }

        // Update members table (for healthConcerns, dob, join_date)
        $memberUpdateQuery = "UPDATE members SET healthConcerns=?, dob=?, join_date=? WHERE memberID=?";
        $stmt = $con->prepare($memberUpdateQuery);
        $stmt->bind_param("sssi", $healthConcerns, $dob, $joinDate, $memberID);
        if (!$stmt->execute()) {
            echo "Error updating member: " . $stmt->error;
            exit();
        }
    } else {
        // Add new member
        $userInsertQuery = "INSERT INTO users (email, password, contactNo, name, role) VALUES (?, ?, ?, ?, ?)";
        $stmt = $con->prepare($userInsertQuery);
        $stmt->bind_param("sssss", $email, $password, $phone, $name, $role);
        if (!$stmt->execute()) {
            echo "Error inserting user: " . $stmt->error;
            exit();
        }
        $userID = $stmt->insert_id;

        $memberInsertQuery = "INSERT INTO members (userID, healthConcerns, dob, join_date) VALUES (?, ?, ?, ?)";
        $stmt = $con->prepare($memberInsertQuery);
        $stmt->bind_param("isss", $userID, $healthConcerns, $dob, $joinDate);
        if (!$stmt->execute()) {
            echo "Error inserting member: " . $stmt->error;
            exit();
        }
        $memberID = $stmt->insert_id;
    }

    $_SESSION['success_message'] = isset($_GET['memberID']) ? 'Member updated successfully!' : 'Member added successfully!';
    header("Location: ../viewMembers.php");
    exit();

} else {
    header("Location: ../viewMembers.php"); // Redirect to the form if accessed directly
    exit();
}
?>