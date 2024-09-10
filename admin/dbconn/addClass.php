<?php
session_start();
include '../../connection.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $classID = $_POST['classID'] ?? null;
    $className = $_POST['className'];
    $classImage = $_FILES['classImage'];

    // Handle file upload
    $uploadDir = '../../assets/images/';
    $uploadedFile = '';
    $imageurl ='';
   
    if ($classImage['name']) {
        $uploadedFile = basename($classImage['name']);
        $uploadFile = $uploadDir . $uploadedFile;
        $imageurl = 'assets/images/'.basename($classImage['name']);
        // Move the uploaded file to the uploads directory
        if (!move_uploaded_file($classImage['tmp_name'], $uploadFile)) {
            $_SESSION['error_message'] = 'Error uploading class image.';
            header("Location: ../newClass.php" . ($classID ? "?classID=$classID" : ""));
            exit();
        }
    }

    if ($classID) {
        // Update existing class
        if ($uploadedFile) {
            $query = "UPDATE classes SET className = ?, classImage = ? WHERE classID = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param('ssi', $className, $imageurl, $classID);
        } else {
            $query = "UPDATE classes SET className = ? WHERE classID = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param('si', $className, $classID);
        }
    } else {
        // Insert new class
        $query = "INSERT INTO classes (className, classImage) VALUES (?, ?)";
        $stmt = $con->prepare($query);
        $stmt->bind_param('ss', $className, $imageurl);
    }

    if ($stmt->execute()) {
        $_SESSION['success_message'] = $classID ? 'Class updated successfully!' : 'Class added successfully!';
    } else {
        $_SESSION['error_message'] = 'Error saving class: ' . $stmt->error;
    }

    header("Location: ../viewClasses.php");
    exit();
} else {
    header("Location: ../viewClasses.php"); // Redirect to the form if accessed directly
    exit();
}
