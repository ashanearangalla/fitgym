<div class="sidebar">
        <div>
            <h1>FITNESS WORLD</h1>
            <ul>
                <li><a href="trainerDashboard.php" >My Profile</a></li>
                <li><a href="publicSessions.php" >Public Sessions</a></li>
                <li><a href="privateSessions.php">Private Sessions</a></li>
                <li><a href="privacypolicy.php">Privacy and Policy</a></li>
                <li><a href="noticeboard.php">Notices</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </div>
        <div class="username">
            <i class="fas fa-user"></i>
            <span><?php echo $_SESSION['user']['name']?></span>
        </div>
    </div>