<?php
session_start();
include '../connection.php';

// Assuming the trainer is logged in and their ID is stored in the session
$trainerID = $_SESSION['user']['userID'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
    $image = $_FILES['image'];
    $imagePath = '../assets/images/' . basename($image['name']);

    if (move_uploaded_file($image['tmp_name'], $imagePath)) {
        $imageurl = 'assets/images/' . basename($image['name']);

        // Update trainers table with new image URL
        $trainerUpdateQuery = "UPDATE trainers SET imageurl=? WHERE userID=?";
        $stmt = $con->prepare($trainerUpdateQuery);
        $stmt->bind_param("si", $imageurl, $trainerID);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'imageurl' => $imageurl]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Error updating database: ' . $stmt->error]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Error uploading image']);
    }
}
?>
