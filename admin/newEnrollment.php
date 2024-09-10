<?php
session_start();
include '../connection.php'; // Include your database connection file

// Fetch member ID from GET request
$memberID = $_GET['memberID'] ?? null;

// Initialize variables for existing enrollment
$existingEnrollment = null;
$selectedPackageID = null;
$selectedSubPackageID = null;

// Check if memberID is provided
if ($memberID) {
    // Check if there's an existing enrollment for this member
    $fetchEnrollmentQuery = "SELECT enrollmentID, subPackageID FROM memberenrollments WHERE memberID=?";
    $stmt = $con->prepare($fetchEnrollmentQuery);
    $stmt->bind_param("i", $memberID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $existingEnrollment = $result->fetch_assoc();
        $selectedSubPackageID = $existingEnrollment['subPackageID'];
        
        // Fetch the packageID for the selected subPackageID
        $fetchPackageQuery = "SELECT packageID FROM subpackages WHERE subPackageID=?";
        $stmt = $con->prepare($fetchPackageQuery);
        $stmt->bind_param("i", $selectedSubPackageID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $selectedPackageID = $result->fetch_assoc()['packageID'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debra Admin Panel - New Enrollment</title>
    <link rel="stylesheet" href="../assets/css/styleadmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Load packages into select
            $.ajax({
                url: 'fetch/fetchPackages.php', // This file should fetch packages
                method: 'GET',
                success: function(data) {
                    $('#package-select').html(data);
                    
                    // Load subpackages when package changes
                    $('#package-select').change(function() {
                        let packageID = $(this).val();
                        if (packageID) {
                            $.ajax({
                                url: 'fetch/fetchSubPackages.php',
                                method: 'GET',
                                data: { packageID: packageID },
                                success: function(data) {
                                    $('#subpackage-select').html(data);
                                    <?php if ($existingEnrollment): ?>
                                        $('#subpackage-select').val('<?php echo $selectedSubPackageID; ?>');
                                    <?php endif; ?>
                                }
                            });
                        } else {
                            $('#subpackage-select').html('<option value="">Select a package first</option>');
                        }
                    });

                    // Set existing selections if editing
                    <?php if ($existingEnrollment): ?>
                        $('#package-select').val('<?php echo $selectedPackageID; ?>').change();
                    <?php endif; ?>
                }
            });
        });
    </script>
</head>
<body>
    <div class="admin-container">
        <?php include("sidemenu.php"); ?>

        <div class="content">
            <div class="content-header">
                <h1><?php echo $existingEnrollment ? 'Edit' : 'New'; ?> Enrollment</h1>
            </div>
            
            <div class="content-section-form">
                <form id="enrollment-form" action="dbconn/addEnrollment.php" method="POST">
                    <input type="hidden" name="memberID" value="<?php echo htmlspecialchars($memberID); ?>">
                    <input type="hidden" name="enrollmentID" value="<?php echo htmlspecialchars($existingEnrollment['enrollmentID'] ?? ''); ?>">
                    
                    <div class="form-group">
                        <div class="col">
                            <label for="package-select">Select Package</label>
                            <select style="width: 400px;" id="package-select" name="packageID" required>
                                <option value="">Select a package</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col">
                            <label for="subpackage-select">Select Subpackage</label>
                            <select style="width: 400px;" id="subpackage-select" name="subPackageID" required>
                                <option value="">Select a package first</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="submit-button-form">Assign</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>