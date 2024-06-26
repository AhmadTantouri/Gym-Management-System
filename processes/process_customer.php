<?php
// Include the database connection file
include '../db-config/connection.php';

// Initialize variables to store success and error messages
$error_message = '';
$success_message = '';

// Process the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $first_name = mysqli_real_escape_string($con, $_POST['customer-first-name']);
    $last_name = mysqli_real_escape_string($con, $_POST['customer-last-name']);
    $email = mysqli_real_escape_string($con, $_POST['customer-email']);
    $phone = mysqli_real_escape_string($con, $_POST['customer-phone']);
    $address = mysqli_real_escape_string($con, $_POST['customer-address']);

    // Insert the customer into the database
    $insert_query = "INSERT INTO customers (first_name, last_name, email, phone, address) 
                     VALUES ('$first_name', '$last_name', '$email', '$phone', '$address')";

    if (mysqli_query($con, $insert_query)) {
        $success_message = "Customer added successfully!";
    } else {
        $error_message = "Error adding customer: " . mysqli_error($con);
    }
}

// Redirect back to the add member page with success or error message
header("Location: ../add_members.php?success_message=$success_message&error_message=$error_message");
exit;
?>
