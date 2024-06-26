<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?> Dashboard</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body style="background-image: url('background.jpg'); background-size: cover;">
    <header style="background-color: #333; color: #fff; text-align: center; padding: 20px; position: relative;">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user_info']['username']); ?> (<?php echo $role; ?>)</h1>
        <a href="logout.php" style="position: absolute; right: 20px; top: 20px; background-color: #f00; color: #fff; padding: 10px; text-decoration: none;">Logout</a>
    </header>
