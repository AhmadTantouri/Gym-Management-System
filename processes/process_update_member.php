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
        $update_fields = '';
        foreach ($_POST as $key => $value) {
            // Exclude id and role fields
            if ($key != 'id' && $key != 'role') {
                $update_fields .= "$key='$value', ";
            }
        }
        $update_fields = rtrim($update_fields, ', ');

        $sql = "UPDATE $table SET $update_fields WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo "Member updated successfully";
        } else {
            echo "Error updating member: " . $conn->error;
        }
    } else {
        echo "Invalid role specified.";
    }

    $conn->close();
} else {
    echo "Invalid request method or parameters.";
}
?>
