<?php
session_start();
include '../../connection.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $subPackageID = isset($_POST['subPackageID']) ? $_POST['subPackageID'] : null;
    $packageID = $_POST['packageID'];
    $duration = $_POST['duration'];
    $price = $_POST['price'];

    if ($subPackageID) {
        // Update existing subpackage
        $updateSubpackageQuery = "UPDATE subpackages SET duration = ?, price = ? WHERE subPackageID = ?";
        $stmt = $con->prepare($updateSubpackageQuery);
        $stmt->bind_param("ssi", $duration, $price, $subPackageID);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = 'Subpackage updated successfully!';
        } else {
            $_SESSION['error_message'] = 'Error updating subpackage: ' . $stmt->error;
        }
    } else {
        // Insert new subpackage
        $insertSubpackageQuery = "INSERT INTO subpackages (packageID, duration, price) VALUES (?, ?, ?)";
        $stmt = $con->prepare($insertSubpackageQuery);
        $stmt->bind_param("iss", $packageID, $duration, $price);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = 'Subpackage added successfully!';
        } else {
            $_SESSION['error_message'] = 'Error adding subpackage: ' . $stmt->error;
        }
    }

    header("Location: ../viewSubpackages.php?packageID=" . $packageID);
    exit();
} else {
    header("Location: ../viewPackages.php"); // Redirect to the form if accessed directly
    exit();
}
