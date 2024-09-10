<?php
session_start();
include '../../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $memberID = $_POST['memberID'];
    $packageID = $_POST['packageID'];
    $subPackageID = $_POST['subPackageID'];
    $enrollmentID = $_POST['enrollmentID'] ?? null;

    // Fetch the duration for the selected subPackageID
    $fetchDurationQuery = "SELECT duration FROM subpackages WHERE subPackageID=?";
    $stmt = $con->prepare($fetchDurationQuery);
    $stmt->bind_param('i', $subPackageID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $duration = $row['duration'];

        // Calculate startDate and endDate
        $startDate = date('Y-m-d');
        $endDate = calculateEndDate($startDate, $duration);

        if ($enrollmentID) {
            // Update existing enrollment
            $updateQuery = "UPDATE memberenrollments SET subPackageID=?, startDate=?, endDate=? WHERE enrollmentID=?";
            $stmt = $con->prepare($updateQuery);
            $stmt->bind_param('issi', $subPackageID, $startDate, $endDate, $enrollmentID);
            $stmt->execute();
        } else {
            // Insert new enrollment
            $insertQuery = "INSERT INTO memberenrollments (memberID, subPackageID, startDate, endDate) VALUES (?, ?, ?, ?)";
            $stmt = $con->prepare($insertQuery);
            $stmt->bind_param('iiss', $memberID, $subPackageID, $startDate, $endDate);
            $stmt->execute();
        }

        $_SESSION['success_message'] = 'Enrollment updated successfully!';
        header("Location: ../viewMembers.php"); // Redirect to a view page
        exit();
    } else {
        echo "Invalid subpackage selected.";
        exit();
    }
} else {
    header("Location: ../viewMembers.php"); // Redirect to the view page if accessed directly
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
            $endDate = $startDate;
            break;
        default:
            echo "Invalid duration.";
            exit();
    }
    
    return $endDate->format('Y-m-d');
}
?>