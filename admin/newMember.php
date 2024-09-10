<?php
session_start();
include '../connection.php'; // Include your database connection file

if (isset($_GET['memberID'])) {
    // Display existing member details for editing
    $memberID = $_GET['memberID'];

    // Fetch member details from database
    $fetchMemberQuery = "SELECT u.userID, u.email, u.contactNo, u.name, m.healthConcerns, m.dob, m.join_date 
                         FROM users u 
                         JOIN members m ON u.userID = m.userID 
                         WHERE m.memberID = ?";
    $stmt = $con->prepare($fetchMemberQuery);
    $stmt->bind_param("i", $memberID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $email = $row['email'];
        $userID = $row['userID'];
        $phone = $row['contactNo'];
        $healthConcerns = $row['healthConcerns'];
        $dob = $row['dob'];
        $joinDate = $row['join_date'];
    } else {
        echo "Member not found.";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debra Admin Panel - <?php echo isset($_GET['memberID']) ? 'Edit Member' : 'Add Member'; ?></title>
    <link rel="stylesheet" href="../assets/css/styleadmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="admin-container">
        <?php include("sidemenu.php"); ?>

        <div class="content">
            <div class="content-header">
                <h1><?php echo isset($_GET['memberID']) ? 'Edit Member' : 'Add Member'; ?></h1>
            </div>
            
            <div id="create-member" class="content-section-form">
                <form id="member-form" action="<?php echo isset($_GET['memberID']) ? 'dbconn/addMember.php?memberID=' . $_GET['memberID'].'&userID='.$userID : 'dbconn/addMember.php'; ?>" method="POST">
                    <div class="form-group">
                        <div class="col">
                            <label for="member-name">Name</label>
                            <input type="text" id="member-name" name="name" placeholder="Name" required value="<?php echo isset($name) ? $name : ''; ?>">
                        </div>
                        <div class="col">
                            <label for="member-email">Email</label>
                            <input type="email" id="member-email" name="email" placeholder="Email" required value="<?php echo isset($email) ? $email : ''; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col">
                            <label for="member-phone">Phone No</label>
                            <input type="text" id="member-phone" name="phone" placeholder="Phone No" required value="<?php echo isset($phone) ? $phone : ''; ?>">
                        </div>
                        <div class="col">
                            <label for="member-dob">Date of Birth</label>
                            <input type="date" id="member-dob" name="dob" value="<?php echo isset($dob) ? $dob : ''; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col">
                            <label for="member-password">Password</label>
                            <input type="password" id="member-password" name="password" placeholder="Password" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div style="width:900px;" class="col">
                            <label for="member-health-concerns">Health Concerns</label>
                            <textarea id="member-health-concerns" name="healthConcerns" rows="4" placeholder="Health Concerns"><?php echo isset($healthConcerns) ? $healthConcerns : ''; ?></textarea>
                        </div>
                    </div>
                    <button type="submit" class="submit-button-form" id="btn-submit"><?php echo isset($_GET['memberID']) ? 'Edit Member' : 'Add Member'; ?></button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>