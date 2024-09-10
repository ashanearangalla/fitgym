<?php
include '../../connection.php';

$packageID = $_GET['packageID'] ?? null;

if ($packageID) {
    $query = "SELECT subPackageID, duration FROM subpackages WHERE packageID=?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('i', $packageID);
    $stmt->execute();
    $result = $stmt->get_result();

    $options = '';
    while ($row = $result->fetch_assoc()) {
        $options .= "<option value='{$row['subPackageID']}'>{$row['duration']}</option>";
    }

    echo $options;
} else {
    echo '<option value="">Select a package first</option>';
}
?>