<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membership Form - FITNESS WORLD</title>
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
        .form-container {
            
            padding: 2rem;
            max-width: 600px;
            margin: 100px auto 2rem auto;
            background-color: #333;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 200px;
        }
        .form-container h2 {
            color: #FFCC00;
            margin-bottom: 1rem;
            text-align: center;
        }
        .form-container form {
            display: flex;
            flex-direction: column;
        }
        .form-container form input,
        .form-container form select,
        .form-container form textarea {
            margin-bottom: 1rem;
            padding: 0.75rem;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
        }
        .form-container form button {
            padding: 0.75rem;
            background-color: #FFCC00;
            color: #000;
            border: none;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s, color 0.3s;
            border-radius: 4px;
        }
        .form-container form button:hover {
            background-color: #000;
            color: #FFCC00;
        }
        footer {
            background-color: #FFCC00;
            color: #000;
            padding: 1rem;
            text-align: center;
        }
        footer a {
            color: #000;
            text-decoration: none;
        }
        .errors-box {
            
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
            <a href="package.php">Packages</a>
            <a href="index.php#contact">Contact</a>
            <a href="login.php">Login/Sign Up</a>
        </nav>
    </header>

    <div class="form-container">
        <h2>Membership Form</h2>
        <form id="registrationForm" name="registrationForm" action="registration_db_model.php" method="post" onsubmit="return validateForm()">
            <input type="text" name="fullName" id="fullName" placeholder="Full Name" >
            <input type="email" name="email" id="email" placeholder="Email" >
            <input type="password" name="password" id="password" placeholder="Password" >
            <input type="text" name="contactNo" id="contactNo" placeholder="Contact No" >
            <input type="date" name="dob" id="dob" placeholder="Date of Birth" >
            <textarea name="healthConcerns" id="healthConcerns" placeholder="Any Health Concerns" rows="4"></textarea>
            <div class="errors-box" id="errorsBox"></div>
            <button type="submit">Submit</button>
            
        </form>
        <p>Already have an account? <a href="login.php">Sign up here</a></p>
    </div>
  
    <footer>
        <!-- Footer content -->
    </footer>

    <script>
        function validateForm() {
            var fullName = document.getElementById('fullName').value.trim();
            var email = document.getElementById('email').value.trim();
            var password = document.getElementById('password').value.trim();
            var contactNo = document.getElementById('contactNo').value.trim();
            var dob = document.getElementById('dob').value.trim();

            var errors = [];

            if (fullName === '') {
                errors.push("Full Name is required");
            }
            else if (email === '') {
                errors.push("Email is required");
            }
            else if (password === '') {
                errors.push("Password is required");
            }
            else if (contactNo === '') {
                errors.push("Contact No is required");
            }
            else if (dob === '') {
                errors.push("Date of Birth is required");
            }

            // Display earrors
            var errorsBox = document.getElementById('errorsBox');
            errorsBox.innerHTML = '';
            if (errors.length > 0) {
                errors.forEach(function(error) {
                    var errorElement = document.createElement('p');
                    errorElement.textContent = error;
                    errorsBox.appendChild(errorElement);
                });
                return false; // Prevent form submission
            }

            return true; // Allow form submission
        }
    </script>
</body>
</html>
