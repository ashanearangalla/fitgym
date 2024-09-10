<?php
include '../../connection.php';

$query = "SELECT packageID, packageType FROM packages";
$result = mysqli_query($con, $query);

$options = ' <option hidden value="">Select a package</option>';
while ($row = mysqli_fetch_assoc($result)) {
    $options .= "<option value='{$row['packageID']}'>{$row['packageType']}</option>";
}

echo $options;
?>