<?php
// Include the database connection file
include '../db-config/connection.php';

// Initialize variables to store success and error messages
$error_message = '';
$success_message = '';

// Process the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $first_name = mysqli_real_escape_string($con, $_POST['dietitian-first-name']);
    $last_name = mysqli_real_escape_string($con, $_POST['dietitian-last-name']);
    $email = mysqli_real_escape_string($con, $_POST['dietitian-email']);
    $phone = mysqli_real_escape_string($con, $_POST['dietitian-phone']);
    $expertise = mysqli_real_escape_string($con, $_POST['dietitian-expertise']);

    // Insert the dietitian into the database
    $insert_query = "INSERT INTO dietitian (first_name, last_name, email, phone, expertise) 
                     VALUES ('$first_name', '$last_name', '$email', '$phone', '$expertise')";

    if (mysqli_query($con, $insert_query)) {
        $success_message = "Dietitian added successfully!";
    } else {
        $error_message = "Error adding dietitian: " . mysqli_error($con);
    }
}

// Redirect back to the add member page with success or error message
header("Location: ../add_members.php?success_message=$success_message&error_message=$error_message");
exit;
?>
