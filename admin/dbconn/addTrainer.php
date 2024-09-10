<?php
session_start();
include '../../connection.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Common fields for both add and edit
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Encrypt the password
    $phone = $_POST['phone'];
    $title = $_POST['title'];
    $about = $_POST['about'];
    $role = 'Trainer';
    $imagePath = '';
    $imageurl = '';

    // If trainerID is set, update existing trainer, otherwise insert new trainer
    if (isset($_GET['trainerID'])) {
        // Edit existing trainer
        $trainerID = $_GET['trainerID'];
        $userID = $_GET['userID'];

        // Update users table (for email, password, phone, name)
        $userUpdateQuery = "UPDATE users SET email=?, password=?, contactNo=?, name=? WHERE userID=?";
        $stmt = $con->prepare($userUpdateQuery);
        $stmt->bind_param("ssssi", $email, $password, $phone, $name, $userID);
        if (!$stmt->execute()) {
            echo "Error updating user: " . $stmt->error;
            exit();
        }

        // Fetch current image URL if no new image is uploaded
        if (empty($_FILES['image']['name'])) {
            $fetchCurrentImageQuery = "SELECT imageurl FROM trainers WHERE trainerID=?";
            $stmt = $con->prepare($fetchCurrentImageQuery);
            $stmt->bind_param("i", $trainerID);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $imageurl = $row['imageurl'];
            }
        } else {
            // Handle image upload if a new image is provided
            $image = $_FILES['image'];
            $imagePath = '../../assets/images/' . basename($image['name']);
            move_uploaded_file($image['tmp_name'], $imagePath);
            $imageurl = 'assets/images/' . basename($image['name']);
        }

        // Update trainers table (for title, about, imageurl)
        $trainerUpdateQuery = "UPDATE trainers SET title=?, about=?, imageurl=? WHERE trainerID=?";
        $stmt = $con->prepare($trainerUpdateQuery);
        $stmt->bind_param("sssi", $title, $about, $imageurl, $trainerID);
        if (!$stmt->execute()) {
            echo "Error updating trainer: " . $stmt->error;
            exit();
        }
    } else {
        // Add new trainer
        $userInsertQuery = "INSERT INTO users (email, password, contactNo, name, role) VALUES (?, ?, ?, ?, ?)";
        $stmt = $con->prepare($userInsertQuery);
        $stmt->bind_param("sssss", $email, $password, $phone, $name, $role);
        if (!$stmt->execute()) {
            echo "Error inserting user: " . $stmt->error;
            exit();
        }
        $userID = $stmt->insert_id;

        $trainerInsertQuery = "INSERT INTO trainers (userID, title, about, imageurl) VALUES (?, ?, ?, ?)";
        $stmt = $con->prepare($trainerInsertQuery);
        $stmt->bind_param("isss", $userID, $title, $about, $imageurl);
        if (!$stmt->execute()) {
            echo "Error inserting trainer: " . $stmt->error;
            exit();
        }
        $trainerID = $stmt->insert_id;
    }

    // Fetch existing specialties if editing
    $existingSpecialties = [];
    if (isset($_GET['trainerID'])) {
        $fetchSpecialtiesQuery = "SELECT specialty FROM trainerspecialties WHERE trainerID=?";
        $stmt = $con->prepare($fetchSpecialtiesQuery);
        $stmt->bind_param("i", $trainerID);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $existingSpecialties[] = $row['specialty'];
        }
    }

    // Insert or update trainer specialties
    if (isset($_POST['specialityName'])) {
        $newSpecialties = $_POST['specialityName'];
        foreach ($newSpecialties as $speciality) {
            if (!in_array($speciality, $existingSpecialties)) {
                $specialtyInsertQuery = "INSERT INTO trainerspecialties (trainerID, specialty) VALUES (?, ?)";
                $stmt = $con->prepare($specialtyInsertQuery);
                $stmt->bind_param("is", $trainerID, $speciality);
                if (!$stmt->execute()) {
                    echo "Error inserting specialty: " . $stmt->error;
                    exit();
                }
            }
        }
    }

    $_SESSION['success_message'] = isset($_GET['trainerID']) ? 'Trainer updated successfully!' : 'Trainer added successfully!';
    header("Location: ../viewTrainers.php");
    exit();

} else {
    header("Location: ../viewTrainers.php"); // Redirect to the form if accessed directly
    exit();
}
?>