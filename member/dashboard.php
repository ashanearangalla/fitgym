<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="../assets/css/accountstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
 
</head>
<body>
    <div class="sidebar">
        <div>
            <h1>FITNESS WORLD</h1>
            <ul>
                <li><a href="dashboard.html" class="active">My Bookings</a></li>
                <li><a href="myclass.html" >My Classes</a></li>
                <li><a href="privacypolicy.html">My Packages</a></li>
                <li><a href="privacypolicy.html">Privacy and Policy</a></li>
                <li><a href="noticeboard.html">Notices</a></li>
                <li><a href="#">Logout</a></li>
            </ul>
        </div>
        <div class="username">
            <i class="fas fa-user"></i>
            <span>Username</span>
        </div>
    </div>
    <div class="content">
        <div class="heading">
            <h2>My Profile</h2>
        </div>
        <div class="profile-card">
            <div class="profile-box">
                <img id="profilePicture" src="https://via.placeholder.com/150" alt="Profile Picture">
                <div class="upload-btn">
                    <input type="file" id="uploadImage" accept="image/*" style="display:none" onchange="previewImage(event)">
                    <button onclick="document.getElementById('uploadImage').click()">Upload Image</button>
                </div>
            </div>
            
            <div class="profile-details">
                <form>
                    <h2>Kevin Anderson</h2>
                    <p><strong>Job Title:</strong> <input type="text" value="Web Designer"></p>
                    <p><strong>Company:</strong> <input type="text" value="Lueilwitz, Wisoky and Leuschke"></p>
                    <p><strong>Country:</strong> <input type="text" value="USA"></p>
                    <p><strong>Address:</strong> <input type="text" value="A108 Adam Street, New York, NY 535022"></p>
                    <p><strong>Phone:</strong> <input type="tel" value="(436) 486-3538 x29071"></p>
                    <p><strong>Email:</strong> <input type="email" value="k.anderson@example.com"></p>
                    <div class="changeSubmit-btn">
                        <input type="submit" value="Update">
                    </div>
                </form>
            </div>
            
        </div>
    </div>


    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('profilePicture');
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>
</html>
