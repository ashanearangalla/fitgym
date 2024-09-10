<?php
session_start();
include '../../connection.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $packageID = isset($_POST['packageID']) ? $_POST['packageID'] : null;
    $packageName = $_POST['packageName'];
    $packageType = $_POST['packageType'];

    if ($packageID) {
        // Update existing package
        $updatePackageQuery = "UPDATE packages SET packageName = ?, packageType = ? WHERE packageID = ?";
        $stmt = $con->prepare($updatePackageQuery);
        $stmt->bind_param("ssi", $packageName, $packageType, $packageID);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = 'Package updated successfully!';
        } else {
            $_SESSION['error_message'] = 'Error updating package: ' . $stmt->error;
        }
    } else {
        // Insert new package
        $insertPackageQuery = "INSERT INTO packages (packageName, packageType) VALUES (?, ?)";
        $stmt = $con->prepare($insertPackageQuery);
        $stmt->bind_param("ss", $packageName, $packageType);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = 'Package added successfully!';
        } else {
            $_SESSION['error_message'] = 'Error adding package: ' . $stmt->error;
        }
    }

    header("Location: ../viewPackages.php");
    exit();
} else {
    header("Location: ../viewPackages.php"); // Redirect to the form if accessed directly
    exit();
}
