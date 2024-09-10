<?php
session_start();

// Database connection
include('../connection.php');

// Fetch classes
$query = "SELECT * FROM classes";
$result = mysqli_query($con, $query);
$classes = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debra Admin Panel - Classes Overview</title>
    <link rel="stylesheet" href="../assets/css/styleadmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Add any additional styles specific to viewClasses.php */
    </style>
</head>
<body>
    <div class="admin-container">
        <?php include("sidemenu.php"); ?>

        <div class="content">
            <div class="content-header">
                <h1>Classes</h1>
            </div>
            
            <div class="content-section">
                <table class="event-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Class Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($classes) {
                            $count = 1;
                            foreach ($classes as $class) {
                                echo "<tr>
                                        <td>{$count}</td>
                                        <td>{$class['className']}</td>
                                        <td>
                                            <a href='viewClassSchedule.php?classID={$class['classID']}' class='view-button'>View Schedule</a>
                                            <a href='newClass.php?classID={$class['classID']}' class='edit-button'>Edit</a>
                                            <form method='post' action='' style='display:inline-block;'>
                                                <input type='hidden' name='classID' value='{$class['classID']}'>
                                                <button type='submit' name='delete' class='delete-button'>Delete</button>
                                            </form>
                                        </td>
                                    </tr>";
                                $count++;
                            }
                        } else {
                            echo "<tr><td colspan='3'>No data available</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="bottom-box">
                <a href="newClass.php"><button class="button-main">Add Class</button></a>
            </div>
        </div>
    </div>
    <script src="../assets/js/admin.js"></script>
</body>
</html>

<?php
// Handle delete request
if (isset($_POST['delete'])) {
    $classID = $_POST['classID'];
    
    // Delete class query
    $deleteQuery = "DELETE FROM classes WHERE classID = ?";
    $stmt = $con->prepare($deleteQuery);
    $stmt->bind_param('i', $classID);
    
    if ($stmt->execute()) {
        echo "<script>alert('Class deleted successfully'); window.location.href='viewClasses.php';</script>";
    } else {
        echo "<script>alert('Error deleting class'); window.location.href='viewClasses.php';</script>";
    }
}
?>