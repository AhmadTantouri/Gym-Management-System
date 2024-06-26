<?php
// Include the database connection file
include '../db-config/connection.php';

// Initialize variables to store success and error messages
$error_message = '';
$success_message = '';

// Process the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $first_name = mysqli_real_escape_string($con, $_POST['trainer-first-name']);
    $last_name = mysqli_real_escape_string($con, $_POST['trainer-last-name']);
    $email = mysqli_real_escape_string($con, $_POST['trainer-email']);
    $phone = mysqli_real_escape_string($con, $_POST['trainer-phone']);
    $specialty = mysqli_real_escape_string($con, $_POST['trainer-specialty']);

    // Insert the trainer into the database
    $insert_query = "INSERT INTO trainer (first_name, last_name, email, phone, specialty) 
                     VALUES ('$first_name', '$last_name', '$email', '$phone', '$specialty')";

    if (mysqli_query($con, $insert_query)) {
        $success_message = "Trainer added successfully!";
    } else {
        $error_message = "Error adding trainer: " . mysqli_error($con);
    }
}

// Redirect back to the add member page with success or error message
header("Location: ../add_members.php?success_message=$success_message&error_message=$error_message");
exit;
?>
