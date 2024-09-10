<?php
    include("connection.php");
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FITNESS WORLD</title>
    <link rel="stylesheet" href="assets/css/stylesheetmain.css">
</head>
<body>


<header>
    <h1>FITNESS WORLD</h1>
    <nav>
        <a href="index.php">Home</a>
        <a href="#about">About Us</a>
        <a href="#trainers">Trainers</a>
        <a href="#classes">Classes</a>
        <a href="packages.php">Packages</a>
        <a href="#contact">Contact</a>
        <a href="login.php">Login/Sign Up</a>
    </nav>
</header>

<section class="hero">
    <h1>What hurts today,</h1>
    <h1>Makes you stronger tomorrow</h1>
    <button id="top"><a href="registration.php" style="text-decoration: none; color: inherit;">JOIN NOW</a></button>
</section>

<section class="about" id="about">
    <div class="about-content">
        <img src="assets/images/about4.jpg" alt="Gym Image">
        <div class="about-text">
            <h2>About Us</h2>
            <p>At Colombo we believe Crossfitters come in all shapes and sizes, we are all on a journey towards our own personal best health and fitness levels. A journey that makes us better as athletes, friends and people. Our facility is unlike any other gym you’ve been to before. We pride ourselves not only in providing world class CrossFit training, but we also believe in creating a motivating and dynamic environment. We are the community dedicated to your human evolution, one workout at a time. Come in for a free trial class! Lose some body fat, gain some friends, and get fit for life!</p>
        </div>
    </div>
</section>

<section class="trainers" id="trainers">
    <h2>Our Trainers</h2>
    <div class="trainer-container">
        <?php
        $sql = "SELECT * FROM trainers
                INNER JOIN users on trainers.userID= users.userID";
        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="trainer-card">';
                echo '<img src="' . $row["imageurl"] . '" alt="' . $row["name"] . '">';
                echo '<p>' . $row["name"] . ' - ' . $row["title"] . '</p>';
                echo '<a href="trainer.php?trainerID=' . $row["trainerID"] . '" style="text-decoration: none; color: inherit;">';
                echo '<button style="width: 150px; " class="contact-button">View</button>';
                echo '</a>';
                echo '</div>';
            }
        } else {
            echo "0 results";
        }
        ?>
    </div>
</section>

<section class="classes" id="classes">
    <h2>Classes</h2>
    <div class="class-container">
        <?php
        $sql = "SELECT * FROM classes";
        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="class-card">';
                echo '<img src="' . $row["classimage"] . '" alt="' . $row["className"] . '">';
                echo '<p>' . $row["className"] . '</p>';
                echo '</div>';
            }
        } else {
            echo "0 results";
        }
        ?>
    </div>
    <a href="schedule.php"><button id="top4">View Schedule</button></a>
</section>

<section class="contact" id="contact">
    <div class="contact-container">
        <h2>Contact Us</h2>
        <form  action="submit_contact.php" method="post">
            <div class="form-group">
                <input style="color: black;"  type="text" name="name" placeholder="Name" required>
            </div>
            <div class="form-group">
                <input style="color: black;"  type="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <textarea style="color: black;"  name="message" placeholder="Message" required></textarea>
            </div>
            <button type="submit">Submit</button>
        </form>
    </div>
</section>

<footer>
    <p>© 2024 FITNESS WORLD. All rights reserved.</p>
    <p>
        <a href="#" style="color: #fff;">Privacy Policy</a> | <a href="#" style="color: #fff;">Terms of Service</a>
    </p>
</footer>

<?php $con->close(); ?>
</body>
</html>