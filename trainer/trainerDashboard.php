<?php
session_start();
include '../connection.php';

// Assuming the trainer is logged in and their ID is stored in the session
$trainerID = $_SESSION['user']['userID'];

// Fetch trainer information
$sql = "SELECT u.name, u.email, u.contactNo, t.title, t.about, t.imageurl
        FROM users u
        JOIN trainers t ON u.userID = t.userID
        WHERE u.userID = ?";
        
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $trainerID);
$stmt->execute();
$result = $stmt->get_result();
$trainer = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updateProfile'])) {
    // Updating trainer info
    $name = $_POST['trainername'];
    $email = $_POST['email'];
    $phone = $_POST['contactNo'];
    $title = $_POST['title'];
    $about = $_POST['about'];
    $imageurl = $trainer['imageurl']; // Current image URL

    // Update users table (for email, phone, name)
    $userUpdateQuery = "UPDATE users SET email=?, contactNo=?, name=? WHERE userID=?";
    $stmt = $con->prepare($userUpdateQuery);
    $stmt->bind_param("sssi", $email, $phone, $name, $trainerID);
    if (!$stmt->execute()) {
        echo "Error updating user: " . $stmt->error;
        exit();
    }

    // Update trainers table (for title, about, imageurl)
    $trainerUpdateQuery = "UPDATE trainers SET title=?, about=?, imageurl=? WHERE userID=?";
    $stmt = $con->prepare($trainerUpdateQuery);
    $stmt->bind_param("sssi", $title, $about, $imageurl, $trainerID);
    if (!$stmt->execute()) {
        echo "Error updating trainer: " . $stmt->error;
        exit();
    }

    $_SESSION['success_message'] = 'Profile updated successfully!';
    header("Location: trainerDashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['uploadImage'])) {
    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image'];
        $imagePath = '../assets/images/' . basename($image['name']);
        if (move_uploaded_file($image['tmp_name'], $imagePath)) {
            $imageurl = 'assets/images/' . basename($image['name']);
            // Update trainers table for imageurl
            $imageUpdateQuery = "UPDATE trainers SET imageurl=? WHERE userID=?";
            $stmt = $con->prepare($imageUpdateQuery);
            $stmt->bind_param("si", $imageurl, $trainerID);
            if ($stmt->execute()) {
                $_SESSION['success_message'] = 'Image uploaded successfully!';
                header("Location: trainerDashboard.php");
                exit();
            } else {
                echo "Error updating image: " . $stmt->error;
                exit();
            }
        } else {
            echo "Error uploading image.";
            exit();
        }
    }
}

$con->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainer Profile</title>
    <link rel="stylesheet" href="../assets/css/styleaccount.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <?php include("trainerSidemenu.php"); ?>
    <div class="content">
        <div class="heading">
            <h2>My Profile</h2>
        </div>
        <div class="profile-card-trainer">
        <div class="profile-box">
                <img style="object-fit: cover;" id="profilePicture" src="../<?php echo $trainer['imageurl'] ?: 'https://via.placeholder.com/150'; ?>" alt="Profile Picture">
                <div class="upload-btn">
                    <input type="file" id="uploadImage" name="image" accept="image/*" style="display:none" onchange="uploadImage(event)">
                    <button onclick="document.getElementById('uploadImage').click()">Upload Image</button>
                </div>
            </div>
            <div class="profile-details">
                <form method="POST">
                    <p><strong>Name:</strong> <input type="text" name="trainername" value="<?php echo $trainer['name']; ?>"></p>
                    <p><strong>Email:</strong> <input type="email" name="email" value="<?php echo $trainer['email']; ?>"></p>
                    <p><strong>Contact No:</strong> <input type="text" name="contactNo" value="<?php echo $trainer['contactNo']; ?>"></p>
                    <p><strong>Title:</strong> <input type="text" name="title" value="<?php echo $trainer['title']; ?>"></p>
                    <p><strong>About:</strong> <textarea rows="4" name="about"><?php echo $trainer['about']; ?></textarea></p>
                    <div class="changeSubmit-btn">
                        <input type="submit" name="updateProfile" value="Update">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function uploadImage(event) {
            var file = event.target.files[0];
            var formData = new FormData();
            formData.append('image', file);

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'uploadImage.php', true);

            xhr.onload = function() {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        var output = document.getElementById('profilePicture');
                        output.src = '../' + response.imageurl;
                    } else {
                        alert('Error uploading image: ' + response.error);
                    }
                }
            };

            xhr.send(formData);
        }
    </script>
</body>
</html>