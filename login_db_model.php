<?php
session_start();
require_once("connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['login'])) {
        $email = $_POST["email"];
        $password = $_POST["password"];
        $errors = [];

        // Validate form inputs
        if (empty($email) || empty($password)) {
            $errors["login_incorrect"] = "Please fill in all required fields";
        } else {
            // Fetch user from the database
            $sql = "SELECT * FROM users WHERE email=?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();

                // Verify password
                if (!password_verify($password, $row["password"])) {
                    $errors["login_incorrect"] = "Incorrect login info!";
                }
            } else {
                $errors["login_incorrect"] = "Incorrect login info!";
            }
        }

        if ($errors) {
            $_SESSION["errors_login"] = $errors;
            header("Location: login.php?login=unsuccess");
            die();
        }

        // Base session variables for all users
        $_SESSION["user"] = [
            "userID" => $row["userID"],
            "email" => htmlspecialchars($row["email"]),
            "name" => htmlspecialchars($row["name"]),
            "role" => htmlspecialchars($row["role"]),
            "contactNo" => htmlspecialchars($row["contactNo"])
        ];

        // Additional session variables for members
        if ($row["role"] === 'Member') {
            $memberSql = "SELECT memberID, join_date FROM members WHERE userID = ?";
            $memberStmt = $con->prepare($memberSql);
            $memberStmt->bind_param("i", $row["userID"]);
            $memberStmt->execute();
            $memberResult = $memberStmt->get_result();

            if ($memberResult->num_rows > 0) {
                $memberRow = $memberResult->fetch_assoc();
                $_SESSION["user"]["memberID"] = $memberRow["memberID"];
                $_SESSION["user"]["join_date"] = $memberRow["join_date"];
            }
            $memberStmt->close();
        }

        // Additional session variables for trainers
        if ($row["role"] === 'Trainer') {
            $trainerSql = "SELECT trainerID, title, about, imageurl FROM trainers WHERE userID = ?";
            $trainerStmt = $con->prepare($trainerSql);
            $trainerStmt->bind_param("i", $row["userID"]);
            $trainerStmt->execute();
            $trainerResult = $trainerStmt->get_result();

            if ($trainerResult->num_rows > 0) {
                $trainerRow = $trainerResult->fetch_assoc();
                $_SESSION["user"]["trainerID"] = htmlspecialchars($trainerRow["trainerID"]);
                $_SESSION["user"]["title"] = htmlspecialchars($trainerRow["title"]);
                $_SESSION["user"]["about"] = htmlspecialchars($trainerRow["about"]);
                $_SESSION["user"]["imageurl"] = htmlspecialchars($trainerRow["imageurl"]);
            }
            $trainerStmt->close();
        }

        // Additional session variables for admins
        if ($row["role"] === 'Admin') {
            $adminSql = "SELECT adminID FROM admins WHERE userID = ?";
            $adminStmt = $con->prepare($adminSql);
            $adminStmt->bind_param("i", $row["userID"]);
            $adminStmt->execute();
            $adminResult = $adminStmt->get_result();

            if ($adminResult->num_rows > 0) {
                $adminRow = $adminResult->fetch_assoc();
                $_SESSION["user"]["adminID"] = $adminRow["adminID"];
            }
            $adminStmt->close();
        }

        // Rediarect based on user role
        switch ($row["role"]) {
            case 'Admin':
                echo '<script>window.location = "admin/viewTrainers.php";</script>';
                break;
            case 'Trainer':
                echo '<script>window.location = "trainer/trainerDashboard.php";</script>';
                break;
            case 'Member':
                echo '<script>window.location = "member/account.php";</script>';
                break;
            default:
                echo '<script>window.location = "index.php";</script>';
        }
        die();
    }
} else {
    header("Location: index.php");
    die();
}
?>
