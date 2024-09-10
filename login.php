<?php
                session_start();

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/Sign Up - FITNESS WORLD</title>
    <style>
        * {
            text-decoration: none;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #000;
            color: #fff;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        header {
            background-color: #333;
            color: #FFCC00;
            padding: 1rem 0;
            text-align: center;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }
        nav {
            display: flex;
            justify-content: center;
            gap: 1rem;
        }
        nav a {
            color: #fff;
            text-decoration: none;
            padding: 0.5rem 1rem;
        }
        .container {
            background-color: #333;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
            margin: 80px auto 0; /* Adjusted margin for fixed header */
        }
        .container h1 {
            color: #FFCC00;
            margin-bottom: 1rem;
        }
        .container form {
            display: flex;
            flex-direction: column;
        }
        .container form input {
            margin-bottom: 1rem;
            padding: 0.5rem;
            border: none;
            border-radius: 4px;
        }
        .container form div button{
            padding: 0.5rem;
            background-color: #FFCC00;
            color: #000;
            border: none;
            cursor: pointer;
            width: 400px;
            border-radius: 4px;
            font-weight: bold;
            transition: background-color 0.3s, color 0.3s;
        }
        .login:hover {
            background-color: #000;
            color: #FFCC00;
        }
        .toggle-button {
            background: none;
            border: none;
            color: #FFCC00;
            cursor: pointer;
            text-decoration: underline;
            margin-top: 1rem;
        }
        footer {
            background-color: #FFCC00;
            color: #000;
            padding: 1rem;
            text-align: center;
            margin-top: auto;
        }
        footer a {
            color: #000;
            text-decoration: none;
        }

        .errors-box {
            margin-top: 10px;
            height: 20px;
            margin-bottom: 5px;
        }

        .errors {
            margin-top: 10px;
            display: flex;
            justify-content: center;
        }

        #correct {
            color: rgb(8, 211, 46);
            font-size: 20px;
        }

        #error {
            color: rgb(229, 11, 11);
            font-size: 20px;
        }

        a {
            color: white;
        }

        /* visited link */
        a:visited {
            color: white;
        }

        /* mouse over link */
        a:hover {
            color: rgb(211, 211, 211);
        }

        /* selected link */
        a:active {
            color: white;
        }
    </style>
</head>
<body>
<header>
        <h1>FITNESS WORLD</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="index.php#about">About Us</a>
            <a href="index.php#trainers">Trainers</a>
            <a href="index.php#classes">Classes</a>
            <a href="packages.php">Packages</a>
            <a href="index.php#contact">Contact</a>
            <a href="login.php">Login/Sign Up</a>
        </nav>
    </header>
    <br><br><br><br><br><br><br><br>
    <div class="container">
        <h1>Login</h1>
        <form id="form1" name="form1" action="login_db_model.php" method="post" onsubmit="return validateForm()">
            <input style="height: 30px; font-size: 15px;" type="email" name="email" id="email" placeholder="Email">
            <input style="height: 30px; font-size: 15px" type="password" name="password" id="password" placeholder="Password">
            <div class="login-button">
                <?php

                if (isset($_SESSION["errors_login"])) {
                    $errors = $_SESSION["errors_login"];
                    foreach ($errors as $error) {
                        echo '<p id="error" style="margin-bottom: 5px; margin-top: 5px; font-size: 13px; text-align: center;">' . $error . '</p>';
                        break;
                    }
                    unset($_SESSION["errors_login"]);
                } else {
                    echo '<p id="error" style="margin-bottom: 5px; margin-top: 5px; font-size: 13px; text-align: center;"></p>';
                }
                ?>
                <button style="height: 40px; font-size: 15px" class="login" type="submit" name="login">Login</button>
            </div>
        </form>
        <p>Don't have an account? <a href="registration.php">Sign up here</a></p>
    </div>
    <footer>
        <p>© 2024 FITNESS WORLD. All rights reserved.</p>
        <p>
            <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a>
        </p>
    </footer>
</body>
<script>
    function validateForm() {
        var email = document.forms["form1"]["email"].value.trim();
        var password = document.forms["form1"]["password"].value.trim();

        if (email == "" || password == "") {
            document.getElementById("error").innerHTML = "Please fill in all required fields";
            return false;
        }
        return true;
    }
</script>
</html>
