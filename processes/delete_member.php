<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']) && isset($_POST['role'])) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "gym system";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $id = $_POST['id'];
    $role = $_POST['role'];
    $table = '';

    switch ($role) {
        case 'customer':
            $table = 'customers';
            break;
        case 'trainer':
            $table = 'trainer';
            break;
        case 'dietitian':
            $table = 'dietitian';
            break;
    }

    if ($table) {
        $sql = "DELETE FROM $table WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            echo "<p style='text-align:center;'>Member deleted successfully</p>";
        } else {
            echo "<p style='text-align:center;'>Error deleting member: " . $conn->error . "</p>";
        }
    } else {
        echo "<p style='text-align:center;'>Invalid role specified.</p>";
    }

    $conn->close();
} else {
    echo "<p style='text-align:center;'>Invalid request method or parameters.</p>";
}
?>
