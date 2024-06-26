<?php
$title = "Admin";
$role = "Admin";
include 'header.php';
?>
    <div class="dashboard-container">
        <div class="dashboard-section">
            <h2>Administration</h2>
            <ul>
                <li><a href="manage_users.php">Manage Users</a></li>
                <li><a href="add_members.php">Add Members</a></li>
                <li><a href="view_members.php">View Members</a></li>
            </ul>
        </div>
        <div class="dashboard-section">
            <h2>Attendance</h2>
            <ul>
                <li><a href="attendance_management.php">Manage Attendance</a></li>
            </ul>
        </div>
        <div class="dashboard-section">
            <h2>View Details</h2>
            <ul>
                <li><a href="view_feedback.php">View Feedback</a></li>
            </ul>
        </div>
        <div class="dashboard-section">
            <h2>Gym Food</h2>
            <ul>
                <li><a href="add_food.php">Add Food</a></li>
                <li><a href="view_food.php">View Food</a></li>
            </ul>
        </div>
    </div>
</body>
</html>
