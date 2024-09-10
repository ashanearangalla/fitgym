<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainer Profile - FITNESS WORLD</title>
    <link rel="stylesheet" href="assets/css/stylesheetmain.css">
</head>
<body>
    <?php
    include 'connection.php';

    // Get trainerID from URL
    $trainerID = isset($_GET['trainerID']) ? intval($_GET['trainerID']) : 0;

    // Fetch trainer details
    $sql = "SELECT t.trainerID, t.title, t.about, t.imageurl, u.name, u.email, u.contactNo 
            FROM trainers t
            INNER JOIN users u ON t.userID = u.userID
            WHERE t.trainerID = $trainerID";
    $trainerResult = $con->query($sql);

    // Fetch specialties
    $specialties = [];
    $sqlSpecialties = "SELECT specialty 
                       FROM trainerspecialties 
                       WHERE trainerID = $trainerID";
    $specialtiesResult = $con->query($sqlSpecialties);
    if ($specialtiesResult->num_rows > 0) {
        while($row = $specialtiesResult->fetch_assoc()) {
            $specialties[] = $row['specialty'];
        }
    }

    // Fetch training schedule
    $schedule = [];
    $sqlSchedule = "SELECT timeslotID, availableDate 
                    FROM trainingschedules 
                    WHERE trainerID = $trainerID AND sessionType = 'public'";
    $scheduleResult = $con->query($sqlSchedule);
    if ($scheduleResult->num_rows > 0) {
        while($row = $scheduleResult->fetch_assoc()) {
            $schedule[] = $row;
        }
    }

    // Fetch timeslot details
    $timeslots = [];
    if (!empty($schedule)) {
        $timeslotIDs = array_map(function($item) { return $item['timeslotID']; }, $schedule);
        $timeslotIDs = implode(',', $timeslotIDs);
        $sqlTimeslots = "SELECT * FROM timeslots WHERE timeslotID IN ($timeslotIDs)";
        $timeslotResult = $con->query($sqlTimeslots);
        if ($timeslotResult->num_rows > 0) {
            while($row = $timeslotResult->fetch_assoc()) {
                $timeslots[$row['timeslotID']] = $row;
            }
        }
    }

    if ($trainerResult->num_rows > 0) {
        $trainer = $trainerResult->fetch_assoc();
    ?>

    <header>
        <h1>FITNESS WORLD</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="#about">About Us</a>
            <a href="#trainers">Trainers</a>
            <a href="#classes">Classes</a>
            <a href="packages2.html">Packages</a>
            <a href="#contact">Contact</a>
            <a href="login.php">Login/Sign Up</a>
        </nav>
    </header>
    <br><br><br>
    <section class="profile-header">
        <img style="object-fit: cover;" src="<?php echo $trainer['imageurl']; ?>" alt="<?php echo $trainer['name']; ?>">
        <h1><?php echo $trainer['name']; ?></h1>
        <p><?php echo $trainer['title']; ?></p>
    </section>

    <section class="profile-content">
        <h2>About Me</h2>
        <p><?php echo $trainer['about']; ?></p>

        <h2>Specialties</h2>
        <ul>
            <?php foreach ($specialties as $specialty) { ?>
                <li><?php echo $specialty; ?></li>
            <?php } ?>
        </ul>

        <div class="contact-info">
            <h2>Contact Information</h2>
            <p>Email: <?php echo $trainer['email']; ?></p>
            <p>Phone: <?php echo $trainer['contactNo']; ?></p>
            <a href="https://www.facebook.com/anjana.sameera.965?mibextid=ZbWKwL" class="contact-button">Contact on Facebook</a>
        </div>

        <div class="schedule">
            <h2>Training Schedule</h2>
            <?php foreach ($schedule as $slot) { 
                $timeslot = $timeslots[$slot['timeslotID']];
                ?>
                <p><?php echo ucfirst($slot['availableDate']); ?>: <?php echo $timeslot['startTime']; ?> - <?php echo $timeslot['endTime']; ?></p>
            <?php } ?>
        </div>
    </section>

    <footer>
        <p>© 2024 FITNESS WORLD. All rights reserved.</p>
        <p>
            <a href="#" style="color: #fff;">Privacy Policy</a> | <a href="#" style="color: #fff;">Terms of Service</a>
        </p>
    </footer>

    <?php
    } else {
        echo "<p>Trainer not found.</p>";
    }

    $con->close();
    ?>
</body>
</html>