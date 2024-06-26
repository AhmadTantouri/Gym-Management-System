<?php
// Include the database connection file
include 'db-config/connection.php';
session_start();

// Check if customer is logged in
if (!isset($_SESSION['user_info']['username'])) {
    // Redirect to the login page or display an error message
    header("Location: login.php");
    exit(); // Stop further execution
}

// Initialize variables to store success and error messages
$error_message = '';
$success_message = '';

// Process the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input
    if (empty($_POST['feedback_type']) || empty($_POST['message'])) {
        $error_message = "Please fill in all fields.";
    } else {
        $customer_username = $_SESSION['user_info']['username']; // Assuming 'username' is the correct key
        $feedback_type = $_POST['feedback_type'];
        $message = $_POST['message'];

        // Insert the feedback into the database
        $insert_query = "INSERT INTO feedback (customer_username, feedback_type, message) 
                         VALUES ('$customer_username', '$feedback_type', '$message')";

        if (mysqli_query($con, $insert_query)) {
            $success_message = "Thank you for your feedback!";
        } else {
            $error_message = "Error adding feedback: " . mysqli_error($con);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Feedback</title>
    <style>
        /* Add your CSS styles for the page layout, form, error/success messages, etc. */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: transparent; /* Set body background color to transparent */
}

.container {
    width: 50%;
    margin: 50px auto;
    padding: 20px;
    background-color: rgba(255, 255, 255, 0.8); /* Add opacity to the background color */
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
}

h2 {
    margin-top: 0;
    margin-bottom: 20px;
    font-size: 24px;
    color: #333;
    text-align: center;
}

.form-group {
    margin-bottom: 20px;
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
    color: #333;
}

textarea {
    width: calc(100% - 22px);
    height: 150px;
    padding: 10px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}

select, button[type="submit"] {
    width: calc(100% - 22px);
    padding: 10px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}

button[type="submit"] {
    background-color: #4CAF50;
    color: #fff;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button[type="submit"]:hover {
    background-color: #45a049;
}

.error-message,
.success-message {
    padding: 10px;
    margin-bottom: 20px;
    border-radius: 3px;
    text-align: center;
}

.error-message {
    background-color: #f44336;
    color: white;
}

.success-message {
    background-color: #4CAF50;
    color: white;
}

.back-btn {
    display: inline-block;
    margin-top: 20px;
    padding: 10px 20px;
    background-color: #333;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.back-btn:hover {
    background-color: #555;
}

    </style>
    <link rel="stylesheet" href="styles.css">
</head>
<body style="background-image: url('background.jpg'); background-size: cover;">
    <div class="container">
        <h2>Add Feedback</h2>
        <!-- Form -->
        <form method="post" action="">
            <div class="form-group">
                <label for="feedback_type">Feedback Type:</label>
                <select id="feedback_type" name="feedback_type" required>
                    <option value="">Select Type</option>
                    <option value="Gym">Gym</option>
                    <option value="Trainer">Trainer</option>
                    <option value="Dietitian">Dietitian</option>
                    <!-- Add more options if needed -->
                </select>
            </div>
            <div class="form-group">
                <label for="message">Message:</label>
                <textarea id="message" name="message" placeholder="Enter your feedback..." required></textarea>
            </div>
            <button type="submit">Submit Feedback</button>
        </form>
        <!-- Error and success messages -->
        <?php if ($error_message) { ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php } ?>
        <?php if ($success_message) { ?>
            <div class="success-message"><?php echo $success_message; ?></div>
        <?php } ?>

        <!-- Back button to return to dashboard -->
        <a href="dashboard_customer.php" class="back-btn">Back to Dashboard</a>
    </div>
</body>
</html>
