<?php
session_start();

// Database connection
include('../connection.php');

// Fetch trainer details
$query = "SELECT trainers.trainerID, users.userID, users.name AS trainerName, users.email, users.contactNo, trainers.title FROM trainers INNER JOIN users ON trainers.userID = users.userID";
$result = mysqli_query($con, $query);
$trainers = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debra Admin Panel - Trainers Overview</title>
    <link rel="stylesheet" href="../assets/css/styleadmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="admin-container">
        <?php include("sidemenu.php"); ?>

        <div class="content">
            <div class="content-header">
                <h1>Trainers</h1>
            </div>
            
            <div class="content-section">
                <table class="event-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Trainer Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Title</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($trainers) {
                            $count = 1;
                            foreach ($trainers as $trainer) {
                                echo "<tr>
                                        <td>{$count}</td>
                                        <td>{$trainer['trainerName']}</td>
                                        <td>{$trainer['email']}</td>
                                        <td>{$trainer['contactNo']}</td>
                                        <td>{$trainer['title']}</td>
                                        <td>
                                            <a href='viewTrainerSchedule.php?trainerID={$trainer['trainerID']}' class='view-button'>View Schedule</a>
                                            <a href='newTrainer.php?trainerID={$trainer['trainerID']}' class='edit-button'>Edit</a>
                                            <form method='post' action='' style='display:inline-block;'>
                                                <input type='hidden' name='userID' value='{$trainer['userID']}'>
                                                <button type='submit' name='delete' class='delete-button'>Delete</button>
                                            </form>
                                        </td>
                                    </tr>";
                                $count++;
                            }
                        } else {
                            echo "<tr><td colspan='6'>No data available</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="bottom-box">
                    <a href="newTrainer.php"><button class="button-main">Add Trainer</button></a>
            </div>
        </div>
    </div>
    <script src="../assets/js/admin.js"></script>
</body>
</html>

<?php
// Handle delete request
if (isset($_POST['delete'])) {
    $userID = $_POST['userID'];
    
    // Delete trainer query
    $deleteQuery = "DELETE FROM users WHERE userID = ?";
    $stmt = $con->prepare($deleteQuery);
    $stmt->bind_param('i', $userID);
    
    if ($stmt->execute()) {
        echo "<script>alert('Trainer deleted successfully'); window.location.href='viewTrainers.php';</script>";
    } else {
        echo "<script>alert('Error deleting trainer'); window.location.href='viewTrainers.php';</script>";
    }
}
?>