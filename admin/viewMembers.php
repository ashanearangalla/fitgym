<?php
session_start();

// Database connection
include('../connection.php');

// Fetch member details and their enrollments
$query = "SELECT users.name, members.memberID, members.userID, members.join_date, 
                 memberenrollments.enrollmentID, memberenrollments.subPackageID, memberenrollments.startDate, memberenrollments.endDate,
                 subpackages.duration, 
                 packages.packageType
          FROM members
          INNER JOIN users ON members.userID = users.userID
          LEFT JOIN memberenrollments ON members.memberID = memberenrollments.memberID
          LEFT JOIN subpackages ON memberenrollments.subPackageID = subpackages.subPackageID
          LEFT JOIN packages ON subpackages.packageID = packages.packageID";
$result = mysqli_query($con, $query);
$members = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debra Admin Panel - Members Overview</title>
    <link rel="stylesheet" href="../assets/css/styleadmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="admin-container">
        <?php include("sidemenu.php"); ?>

        <div class="content">
            <div class="content-header">
                <h1>Members</h1>
            </div>
            
            <div class="content-section">
                <table class="event-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Join Date</th>
                            <th>Package Type</th>
                            <th>Subpackage Duration</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th style="width: 170px;">Edit Package</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($members) {
                            $count = 1;
                            foreach ($members as $member) {
                                echo "<tr>
                                        <td>{$count}</td>
                                        <td>{$member['name']}</td>
                                        <td>{$member['join_date']}</td>
                                        <td>{$member['packageType']}</td>
                                        <td>{$member['duration']}</td>
                                        <td>{$member['startDate']}</td>
                                        <td>{$member['endDate']}</td>
                                        <td><a href='newEnrollment.php?memberID={$member['memberID']}' class='edit-button'>Edit Package</a>
                                       
                                        </td>
                                        <td>
                                         <a href='newMember.php?memberID={$member['memberID']}' class='edit-button'>Edit</a>
                                            <form method='post' action='' style='display:inline-block;'>
                                                <input type='hidden' name='userID' value='{$member['userID']}'>
                                                <button type='submit' name='delete' class='delete-button'>Delete</button>
                                            </form>
                                        </td>
                                    </tr>";
                                $count++;
                            }
                        } else {
                            echo "<tr><td colspan='9'>No data available</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="bottom-box">
                    <a href="newMember.php"><button class="button-main">Add Member</button></a>
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
    
    // Delete member enrollment query
    $deleteQuery = "DELETE FROM users WHERE userID = ?";
    $stmt = $con->prepare($deleteQuery);
    $stmt->bind_param('i', $userID);
    
    if ($stmt->execute()) {
        echo "<script>alert('Member enrollment deleted successfully'); window.location.href='viewMembers.php';</script>";
    } else {
        echo "<script>alert('Error deleting member enrollment'); window.location.href='viewMembers.php';</script>";
    }
}
?>