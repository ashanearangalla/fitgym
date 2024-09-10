<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Schedule - FITNESS WORLD</title>
    <link rel="stylesheet" href="assets/css/stylesheetmain.css">
    <style>
        .schedule {
            margin-top: 100px; /* Adjusted for the fixed header */
            padding: 2rem;
            text-align: center;
        }
        .schedule h2 {
            color: #FFCC00;
            margin-bottom: 2rem;
        }
        .table-container {
            overflow-x: auto;
            margin-bottom: 2rem;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2rem;
        }
        th, td {
            padding: 1rem;
            border: 1px solid #fff;
            text-align: center;
        }
        th {
            background-color: #333;
            color: #FFCC00;
        }
        footer {
            background-color: #FFCC00;
            color: #000000;
            padding: 1rem;
            text-align: center;
        }
        footer a {
            color: #000000;
            text-decoration: none;
        }
    </style>
</head>
<body>
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

    <section class="schedule">
        <h2>Class Schedule</h2>
        <?php
        include 'connection.php';

        // Fetch class names
        $classes = [];
        $sqlClasses = "SELECT classID, className FROM classes";
        $resultClasses = $con->query($sqlClasses);
        if ($resultClasses->num_rows > 0) {
            while ($row = $resultClasses->fetch_assoc()) {
                $classes[$row['classID']] = $row['className'];
            }
        }

        // Fetch timeslots
        $timeslots = [];
        $sqlTimeslots = "SELECT timeslotID, TIME_FORMAT(startTime, '%h:%i %p') AS startTime, TIME_FORMAT(endTime, '%h:%i %p') AS endTime FROM timeslots";
        $resultTimeslots = $con->query($sqlTimeslots);
        if ($resultTimeslots->num_rows > 0) {
            while ($row = $resultTimeslots->fetch_assoc()) {
                $timeslots[$row['timeslotID']] = $row['startTime'] . ' - ' . $row['endTime'];
            }
        }

        // Fetch class schedule
        $schedule = [];
        $sqlSchedule = "SELECT cs.classID, cs.timeslotID, cs.day 
                        FROM classschedule cs";
        $resultSchedule = $con->query($sqlSchedule);
        if ($resultSchedule->num_rows > 0) {
            while ($row = $resultSchedule->fetch_assoc()) {
                $schedule[$row['classID']][$row['day']][$row['timeslotID']] = true;
            }
        }

        foreach ($classes as $classID => $className) {
            echo "<div class='table-container'>";
            echo "<h3>$className</h3>";
            echo "<table>";
            echo "<thead>";
            echo "<tr>";
            foreach (['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $day) {
                echo "<th>$day</th>";
            }
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            // Collect all times for the current class across all days
            $maxRows = 0;
            $dayTimes = [];
            foreach (['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $day) {
                $dayTimes[$day] = [];
                if (isset($schedule[$classID][$day])) {
                    foreach ($schedule[$classID][$day] as $timeslotID => $exists) {
                        $dayTimes[$day][] = $timeslots[$timeslotID];
                    }
                    $maxRows = max($maxRows, count($dayTimes[$day]));
                }
            }

            // Display rows based on the collected times
            for ($i = 0; $i < $maxRows; $i++) {
                echo "<tr>";
                foreach (['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $day) {
                    echo "<td>";
                    echo isset($dayTimes[$day][$i]) ? $dayTimes[$day][$i] : '';
                    echo "</td>";
                }
                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";
            echo "</div>";
        }

        $con->close();
        ?>
    </section>

    <footer>
        <p>© 2024 FITNESS WORLD. All rights reserved.</p>
        <p>
            <a href="#" style="color: #fff;">Privacy Policy</a> | <a href="#" style="color: #fff;">Terms of Service</a>
        </p>
    </footer>
</body>
</html>
