<?php
session_start();
require_once("connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Initialize variables from the form
    $fullName = $_POST["fullName"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $contactNo = $_POST["contactNo"];
    $dob = $_POST["dob"];
    $healthConcerns = $_POST["healthConcerns"];

    // Validate form inputs (additional client-side validation is recommended)
    $errors = [];

    if (empty($fullName) || empty($email) || empty($password) || empty($contactNo) || empty($dob)) {
        $errors[] = "Please fill in all required fields";
    }

    // Check if email already exists in the database
    $checkEmailSql = "SELECT * FROM users WHERE email=?";
    $checkEmailStmt = $con->prepare($checkEmailSql);
    $checkEmailStmt->bind_param("s", $email);
    $checkEmailStmt->execute();
    $checkEmailResult = $checkEmailStmt->get_result();

    if ($checkEmailResult->num_rows > 0) {
        $errors[] = "Email already exists. Please use a different email.";
    }

    // If errors exist, redirect back with errors
    if (!empty($errors)) {
        $_SESSION["errors_registration"] = $errors;
        header("Location: registration.php?registration=failed");
        exit;
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insert into users table
    $insertUserSql = "INSERT INTO users (email, password, contactNo, name, role) VALUES (?, ?, ?, ?, 'Member')";
    $insertUserStmt = $con->prepare($insertUserSql);
    $insertUserStmt->bind_param("ssss", $email, $hashedPassword, $contactNo, $fullName);
    $insertUserStmt->execute();

    // Get the userID of the inserted user
    $userID = $insertUserStmt->insert_id;

    // Insert into members table
    $insertMemberSql = "INSERT INTO members (userID, healthConcerns, dob, join_date) VALUES (?, ?, ?, NOW())";
    $insertMemberStmt = $con->prepare($insertMemberSql);
    $insertMemberStmt->bind_param("iss", $userID, $healthConcerns, $dob);
    $insertMemberStmt->execute();

    // Get the memberID of the inserted member
    $memberID = $insertMemberStmt->insert_id;

    // Store userID and memberID in session variables
    $_SESSION["userID"] = $userID;
    $_SESSION["memberID"] = $memberID;

    // Redirect to selectPackage.php
    header("Location: selectPackage.php");
    exit;
} else {
    header("Location: registration.php");
    exit;
}
?>