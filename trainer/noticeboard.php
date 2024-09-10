<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="../assets/css/styleaccount.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
 
</head>
<body>
<?php 
        include("trainerSidemenu.php");
    ?>
    <div class="content">
        <div class="heading">
            <h2>Notice Board</h2>
        </div>
        <div class="notice-board">
            <div class="notice">
                <h3>Notice 1: Holiday Closure</h3>
                <p>Dear Members,</p>
                <p>Please note that the gym will be closed on the upcoming Poya day, which falls on the 24th of this month. We apologize for any inconvenience caused and encourage you to plan your workouts accordingly.</p>
            </div>
            <div class="notice">
                <h3>Notice 2: Maintenance Break</h3>
                <p>Dear Members,</p>
                <p>We will be conducting routine maintenance on our equipment on the 28th of this month. The gym will remain closed from 8:00 AM to 12:00 PM. Thank you for your understanding.</p>
            </div>
            <div class="notice">
                <h3>Notice 3: New Classes Available</h3>
                <p>Dear Members,</p>
                <p>We are excited to announce new classes starting from next week. Check out our schedule to find a class that fits your interest!</p>
            </div>
        </div>
        
    </div>


    
</body>
</html>
