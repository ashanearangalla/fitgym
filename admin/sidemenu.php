
<div class="sidebar">

            <div class="logo">
                
                    <h2>Fitness World</h2>
                
            </div>
            
            <ul class="sidemenu-list">
                <li>
                    <a href="viewTrainers.php"><i class="bx bxs-user-pin"></i>&nbsp; Trainers</a>
                </li>
                <li>
                    <a href="viewPackages.php"><i class="bx bxs-user-pin"></i>&nbsp; Packages</a>
                </li>
                <li>
                    <a href="viewClasses.php"><i class='bx bxs-category-alt'></i>&nbsp;Classes</a>
                </li>
                <li>
                    <a href="viewMembers.php"><i class='bx bxs-category-alt'></i>&nbsp;Members</a>
                </li>
                
                <li>
                    <a href="viewPersonalTraining.php"><i class="bx bxs-dashboard"></i>&nbsp;Personal Training</a>
                </li>
                <li>
                    <a href="../logout.php"><i class="bx bxs-category"></i>&nbsp; Logout</a>
                </li>
                
            </ul>
            <div class="sidebar-footer">
        <i class="fas fa-user-circle user-icon"></i>
        <span class="user-name"><?php echo $_SESSION['user']['email']?></span>
    </div>
        
</div>