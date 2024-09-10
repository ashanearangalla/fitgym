<?php
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection file
    require_once("connection.php");

    // Collect form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Validate form inputs (you can add more validation as needed)
    $errors = [];
    if (empty($name) || empty($email) || empty($message)) {
        $errors[] = "All fields are required.";
    } else {
        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format.";
        }
    }

    // If there are errors, redirect back with errors
    if (!empty($errors)) {
        $errorString = implode("<br>", $errors);
        header("Location: index.php?error=" . urlencode($errorString));
        exit();
    }

    // Prepare and execute SQL insert statement
    $sql = "INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        // Success message
        header("Location: index.php?success=" . urlencode("Message sent successfully!"));
        exit();
    } else {
        // Error message
        header("Location: index.php?error=" . urlencode("Failed to send message. Please try again later."));
        exit();
    }

    // Close statement and database connection
    $stmt->close();
    $con->close();
} else {
    // If accessed directly, redirect back to contact page
    header("Location: index.php");
    exit();
}
?>