<?php
session_start(); // Start the session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the workoutId is set and valid
    if (isset($_POST["workoutId"]) && is_numeric($_POST["workoutId"])) {
        // Sanitize the input to prevent SQL injection
        $workoutId = $_POST["workoutId"];

        // Database connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "gym system";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Get the logged-in username from the session
        $loggedInUsername = $_SESSION['user_info']['username'];

        // Prepare and execute SQL statement to delete the workout
        $stmt = $conn->prepare("DELETE FROM workouts WHERE id = ? AND customer_username = ?");
        $stmt->bind_param("is", $workoutId, $loggedInUsername);
        
        if ($stmt->execute()) {
            echo "Workout removed successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        // Invalid or missing workoutId
        echo "Invalid workoutId!";
    }
} else {
    // Not a POST request
    echo "Invalid request method!";
}
?>
