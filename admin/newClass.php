<?php
session_start();
include '../connection.php'; // Include your database connection file

// Initialize variables
$classID = '';
$className = '';
$classImage = '';

// Check if classID is provided for editing
if (isset($_GET['classID'])) {
    $classID = $_GET['classID'];
    
    // Fetch class details for editing
    $query = "SELECT className, classImage FROM classes WHERE classID = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('i', $classID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $class = $result->fetch_assoc();
        $className = $class['className'];
        $classImage = $class['classImage'];
    } else {
        $_SESSION['error_message'] = 'Class not found.';
        header("Location: viewClasses.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debra Admin Panel - <?php echo $classID ? 'Edit' : 'Add'; ?> Class</title>
    <link rel="stylesheet" href="../assets/css/styleadmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="admin-container">
        <?php include("sidemenu.php"); ?>

        <div class="content">
            <div class="content-header">
                <h1><?php echo $classID ? 'Edit' : 'Add'; ?> Class</h1>
            </div>
            
            <div id="create-class" class="content-section-form">
                <form id="class-form" action="dbconn/addClass.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="classID" value="<?php echo $classID; ?>">
                    <div class="form-group">
                        <div style="width: 500px;" class="col">
                            <label for="className">Class Name</label>
                            <input type="text" id="className" name="className" placeholder="Class Name" value="<?php echo htmlspecialchars($className); ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div style="width: 500px;" class="col">
                            <label for="classImage">Class Image</label>
                            <input type="file" id="classImage" name="classImage" <?php echo $classID ? '' : 'required'; ?>>
                            <?php if ($classID && $classImage): ?>
                                <p>Current Image: <img src="../uploads/<?php echo $classImage; ?>" alt="Class Image" width="100"></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <button type="submit" class="submit-button-form"><?php echo $classID ? 'Update' : 'Add'; ?> Class</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
