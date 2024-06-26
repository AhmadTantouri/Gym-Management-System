<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Workout Plan</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        /* Global styles */
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('background.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8); /* Transparent background */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        /* Workout card styles */
        .workout-card {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .workout-card h3 {
            color: #333;
            margin-top: 0;
            font-size: 20px;
        }

        .workout-card p {
            margin: 5px 0;
            color: #666;
        }

        .meta {
            font-size: 14px;
            color: #999;
        }

        /* Button styles */
        .done-button {
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .done-button:hover {
            background-color: #218838;
        }

        /* Error message styles */
        .error-message {
            color: #dc3545;
            margin-top: 10px;
            text-align: center;
        }

        /* Back to Dashboard button */
        .back-btn {
            display: block;
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            margin-top: 20px;
            text-decoration: none; /* Remove underline from anchor tag */
            transition: background-color 0.3s;
        }

        .back-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Customer Workout Plan</h2>
        <?php
        session_start(); // Start the session

        // Get the logged-in username from the session
        $loggedInUsername = $_SESSION['user_info']['username'];

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

        // Fetch workouts for the logged-in customer
        $sql_workouts = "SELECT * FROM workouts WHERE customer_username = '$loggedInUsername'";
        $result_workouts = $conn->query($sql_workouts);

        // Check if there are any workouts for the logged-in customer
        if ($result_workouts->num_rows > 0) {
            // Display the workouts
            while($row_workout = $result_workouts->fetch_assoc()) {
                // Display each workout as a card
                echo "<div class='workout-card'>";
                echo "<h3>{$row_workout['customer_username']}</h3>";
                echo "<p><strong>Exercises:</strong> {$row_workout['exercises']}</p>";
                echo "<p><strong>Rounds:</strong> {$row_workout['rounds']}</p>";
                echo "<p><strong>Reps:</strong> {$row_workout['reps']}</p>";
                echo "<p><strong>Duration:</strong> {$row_workout['duration']} minutes</p>";
                echo "<p><strong>Difficulty:</strong> {$row_workout['difficulty']}</p>";
                echo "<p><strong>Calories Consumed:</strong> {$row_workout['calories_consumed']} kcal per round</p>";
                echo "<p class='meta'><strong>Day:</strong> {$row_workout['day']}</p>";
                echo "<p class='meta'><strong>Created At:</strong> {$row_workout['created_at']}</p>";
                echo "<button class='done-button' onclick='removeWorkout({$row_workout['id']})'>Done</button>";
                echo "</div>";
            }
        } else {
            // No workouts found for the logged-in customer
            echo "<p class='error-message'>No workouts found for this customer.</p>";
        }

        $conn->close();
        ?>

        <a href="dashboard_customer.php" class="back-btn">Back to Dashboard</a>

        <script>
            function removeWorkout(workoutId) {
                if (confirm("Are you sure you want to mark this workout as done?")) {
                    // Send an AJAX request to remove the workout
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "processes/remove_workout.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            // Reload the page after successful removal
                            location.reload();
                        }
                    };
                    xhr.send("workoutId=" + workoutId);
                }
            }
        </script>
    </div>
</body>
</html>
