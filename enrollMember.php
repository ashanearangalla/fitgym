<?php
session_start();
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userID = $_POST['userID'];
    $memberID = $_POST['memberID'];
    $packageID = $_POST['packageID'];
    $subPackageID = $_POST['subPackageID'];

    // Fetch the duration and package type for the selected subPackageID
    $fetchDurationQuery = "SELECT duration, packageType FROM subpackages
                           INNER JOIN packages ON subpackages.packageID = packages.packageID 
                           WHERE subPackageID=?";
    $stmt = $con->prepare($fetchDurationQuery);
    $stmt->bind_param('i', $subPackageID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $duration = $row['duration'];
        $packageType = $row['packageType'];

        // Calculate startDate and endDate
        $startDate = date('Y-m-d');
        $endDate = calculateEndDate($startDate, $duration);

        // Insert new enrollment
        $insertQuery = "INSERT INTO memberenrollments (memberID, subPackageID, startDate, endDate) VALUES (?, ?, ?, ?)";
        $stmt = $con->prepare($insertQuery);
        $stmt->bind_param('iiss', $memberID, $subPackageID, $startDate, $endDate);
        $stmt->execute();

        // Get last inserted ID
        $enrollmentID = $con->insert_id;
        $_SESSION['enrollmentID'] = $enrollmentID;  // Set session variable

        $_SESSION['success_message'] = 'Enrollment completed successfully!';

        // Redirect based on package type
        if ($packageType == 'personal_training') {
            header("Location: selectTrainer.php");
        } else {
            header("Location: login.php");
        }
        exit();
    } else {
        echo "Invalid subpackage selected.";
        exit();
    }
} else {
    header("Location: registration.php");
    exit();
}

// Function to calculate end date based on duration
function calculateEndDate($startDate, $duration) {
    $endDate = new DateTime($startDate);
    
    switch ($duration) {
        case '1_month':
            $endDate->modify('+1 month');
            break;
        case '3_months':
            $endDate->modify('+3 months');
            break;
        case '6_months':
            $endDate->modify('+6 months');
            break;
        case '12_months':
            $endDate->modify('+12 months');
            break;
        case '1_session':
            // If '1_session', endDate can be the same as startDate or any other logic you want
            break;
        default:
            echo "Invalid duration.";
            exit();
    }
    
    return $endDate->format('Y-m-d');
}
?>