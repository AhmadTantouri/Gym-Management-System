<?php
include 'db-config/connection.php';
session_start();

// Sanitize user inputs to prevent SQL injection
$username = mysqli_real_escape_string($con, $_POST['username']);
$password = mysqli_real_escape_string($con, $_POST['password']);
$role = mysqli_real_escape_string($con, $_POST['role']);

// Use prepared statements for security
$query = "SELECT * FROM `user_account` WHERE `username` = ? AND `password` = ? AND `role` = ?";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, 'sss', $username, $password, $role);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$row_num = mysqli_num_rows($result);

if ($row_num > 0) {
    $data = mysqli_fetch_assoc($result);
    $_SESSION["user_info"] = $data;

    // Redirect based on the user role
    switch ($role) {
        case 'admin':
            header('Location: dashboard_admin.php');
            break;
        case 'customer':
            header('Location: dashboard_customer.php');
            break;
        case 'trainer':
            header('Location: dashboard_trainer.php');
            break;
        case 'dietitian':
            header('Location: dashboard_dietitian.php');
            break;
        default:
            header('Location: index.php');
            break;
    }
} else {
    header('Location: index.php?error=1');
}

// Close the statement and connection
mysqli_stmt_close($stmt);
mysqli_close($con);
?>
