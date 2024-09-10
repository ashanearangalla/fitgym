<?php
session_start();
include '../connection.php'; // Include your database connection file

if (isset($_GET['trainerID'])) {
    // Display existing trainer details for editing
    $trainerID = $_GET['trainerID'];

    // Fetch trainer details from database
    $fetchTrainerQuery = "SELECT u.userID, u.email, u.contactNo, u.name, t.title, t.about, t.imageurl 
                         FROM users u 
                         JOIN trainers t ON u.userID = t.userID 
                         WHERE t.trainerID = ?";
    $stmt = $con->prepare($fetchTrainerQuery);
    $stmt->bind_param("i", $trainerID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $email = $row['email'];
        $userID = $row['userID'];
        $phone = $row['contactNo'];
        $title = $row['title'];
        $about = $row['about'];
        $imagePath = $row['imageurl'];
    } else {
        echo "Trainer not found.";
        exit();
    }
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debra Admin Panel - <?php echo isset($_GET['trainerID']) ? 'Edit Trainer' : 'Add Trainer'; ?></title>
    <link rel="stylesheet" href="../assets/css/styleadmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="admin-container">
        <?php include("sidemenu.php"); ?>

        <div class="content">
            <div class="content-header">
                <h1><?php echo isset($_GET['trainerID']) ? 'Edit Trainer' : 'Add Trainer'; ?></h1>
            </div>
            
            <div id="create-trainer" class="content-section-form">
                <form id="trainer-form" action="<?php echo isset($_GET['trainerID']) ? 'dbconn/addTrainer.php?trainerID=' . $_GET['trainerID'].'&userID='.$userID.'' : 'dbconn/addTrainer.php'; ?>" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="col">
                            <label for="trainer-name">Name</label>
                            <input type="text" id="trainer-name" name="name" placeholder="Name" required value="<?php echo isset($name) ? $name : ''; ?>">
                        </div>
                        <div class="col">
                            <label for="trainer-email">Email</label>
                            <input type="email" id="trainer-email" name="email" placeholder="Email" required value="<?php echo isset($email) ? $email : ''; ?>">
                        </div>
                       
                    </div>
                    <div class="form-group"> 
                        <div class="col">
                            <label for="trainer-password">Password</label>
                            <input type="password" id="trainer-password" name="password" placeholder="Password" required>
                        </div>
                        <div class="col">
                            <label for="trainer-phone">Phone No</label>
                            <input type="text" id="trainer-phone" name="phone" placeholder="Phone No" required value="<?php echo isset($phone) ? $phone : ''; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        
                        <div class="col">
                            <label for="trainer-title">Title</label>
                            <input type="text" id="trainer-title" name="title" placeholder="Title" required value="<?php echo isset($title) ? $title : ''; ?>">
                        </div>
                        <div class="col">
                            <label for="trainer-image">Image</label>
                            <input type="file" id="trainer-image" name="image" accept="image/*">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col">
                            <label for="trainer-about">About</label>
                            <textarea style="width:900px;" id="trainer-about" name="about" rows="4" placeholder="About the Trainer"><?php echo isset($about) ? $about : ''; ?></textarea>
                        </div>
                    </div>
                    
                    <div class="ticket-sec">
                        <div class="title-sec">
                            <label for="trainer-specialities">Specialities</label>
                        </div>
                        <div class="ticket-cat">
                            <div class="sec-one">
                                <input type="text" id="speciality-name" placeholder="Speciality">
                            </div>
                            <button type="button" id="add-speciality-btn"><i class="fas fa-plus"></i></button>
                        </div>
                        <div class="table-sec">
                            <table id="speciality-table" class="artist-table" style="margin-bottom: 20px;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Speciality</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Display existing specialties for editing
                                    if (isset($_GET['trainerID'])) {
                                        $fetchSpecialtiesQuery = "SELECT specialty FROM trainerspecialties WHERE trainerID=?";
                                        $stmt = $con->prepare($fetchSpecialtiesQuery);
                                        $stmt->bind_param("i", $_GET['trainerID']);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        $count = 1;
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . $count++ . "</td>";
                                            echo "<td>" . htmlspecialchars($row['specialty']) . "</td>";
                                            echo '<td><button type="button" class="remove-speciality-btn">Remove</button></td>';
                                            echo "</tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <button type="submit" class="submit-button-form" id="btn-submit"><?php echo isset($_GET['trainerID']) ? 'Edit Trainer' : 'Add Trainer'; ?></button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById('trainer-form');
            const specialityTable = document.getElementById('speciality-table').getElementsByTagName('tbody')[0];
            const addSpecialityBtn = document.getElementById('add-speciality-btn');
            let specialityId = <?php echo isset($count) ? $count : 1; ?>;

            function addHiddenInput(name, value) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = name;
                input.value = value;
                form.appendChild(input);
            }

            // Handle add speciality button
            addSpecialityBtn.addEventListener('click', function() {
                const specialityNameInput = document.getElementById('speciality-name');
                const specialityName = specialityNameInput.value.trim();

                if (specialityName === '') {
                    alert('Please enter a speciality.');
                    return;
                }

                // Add speciality to table
                const newRow = specialityTable.insertRow();
                newRow.dataset.specialityId = specialityId;
                const cell1 = newRow.insertCell(0);
                const cell2 = newRow.insertCell(1);
                const cell3 = newRow.insertCell(2);

                cell1.textContent = specialityId++;
                cell2.textContent = specialityName;
                cell3.innerHTML = '<button type="button" class="remove-speciality-btn">Remove</button>';

                // Add hidden inputs
                addHiddenInput(`specialityName[${specialityId}]`, specialityName);

                // Clear input field
                specialityNameInput.value = '';
            });

            // Handle remove speciality button
            specialityTable.addEventListener('click', function(event) {
                if (event.target.classList.contains('remove-speciality-btn')) {
                    const row = event.target.closest('tr');
                    const specialityId = row.dataset.specialityId;
                    // Remove hidden inputs
                    const inputs = form.querySelectorAll(`input[name^="specialityName[${specialityId}]"]`);
                    inputs.forEach(input => input.remove());
                    specialityTable.deleteRow(row.rowIndex - 1); // Adjust for thead row
                }
            });

            // Form submission handler (validate if needed)
            form.addEventListener('submit', function(event) {
                // Validate form fields if necessary
                // event.preventDefault();
                // Add further validation logic here
            });
        });
    </script>
</body>
</html>
