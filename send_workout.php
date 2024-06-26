<?php
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

$error = $success = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    // Retrieve form data
    $customerUsername = $_POST['customer_username'];
    $exercises = $_POST['exercises'];
    $rounds = $_POST['rounds'];
    $reps = $_POST['reps'];
    $duration = $_POST['duration'];
    $difficulty = $_POST['difficulty'];
    $caloriesConsumed = $_POST['calories_consumed'];
    $day = $_POST['day'];

    // Your SQL query and code for inserting workout data into the database here...
    $sql = "INSERT INTO workouts (customer_username, exercises, rounds, reps, duration, difficulty, calories_consumed, day) VALUES ('$customerUsername', '$exercises', '$rounds', '$reps', '$duration', '$difficulty', '$caloriesConsumed', '$day')";
    if ($conn->query($sql) === TRUE) {
        $success = "Workout sent successfully!";
    } else {
        $error = "Error sending workout: " . $conn->error;
    }
}

// Fetch customer usernames from user_account table where type is customer
$sql = "SELECT username FROM user_account WHERE role = 'customer'";
$result = $conn->query($sql);

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Workout to Customer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('background.jpg');
            margin: 0;
            background-size: cover;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 10px;
            color: #555;
        }

        input[type="text"],
        textarea,
        input[type="file"],
        input[type="date"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            margin-bottom: 20px;
            box-sizing: border-box;
            background-color: #f8f9fa;
            color: #555;
        }

        textarea {
            resize: vertical;
        }

        button[type="submit"], button[type="button"] {
            width: 48%;
            padding: 12px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            margin-top: 10px;
        }

        button[type="submit"]:hover, button[type="button"]:hover {
            background-color: #218838;
        }


            .error-message {
            color: #dc3545;
            margin-top: 10px;
            text-align: center;
            font-size: 14px;
        }

        .success-message {
            color: #28a745;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Send Workout to Customer</h2>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
            if (!empty($error)) {
                echo "<p class='error-message'>$error</p>";
            } elseif (!empty($success)) {
                echo "<p class='success-message'>$success</p>";
            }
        }
        ?>
        <form method="post" enctype="multipart/form-data">
            <label for="customer_username">Customer Username:</label>
            <select id="customer_username" name="customer_username" required>
                <?php
                // Display customer usernames as options in the combo box
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["username"] . "'>" . $row["username"] . "</option>";
                    }
                } else {
                    echo "<option value=''>No customers found</option>";
                }
                ?>
            </select>

            <label for="exercises">Exercises:</label>
            <textarea id="exercises" name="exercises" rows="4" required></textarea>

            <label for="rounds">Rounds:</label>
            <input type="text" id="rounds" name="rounds" required>

            <label for="reps">Reps:</label>
            <input type="text" id="reps" name="reps" required>

            <label for="duration">Duration (in minutes):</label>
            <input type="text" id="duration" name="duration" required>

            <label for="exercise_image">Exercise Image:</label>
            <input type="file" id="exercise_image" name="exercise_image" accept="image/*" required>

            <label for="difficulty">Difficulty:</label>
            <input type="text" id="difficulty" name="difficulty" required>

            <label for="calories_consumed">Calories Consumed (per round):</label>
            <input type="text" id="calories_consumed" name="calories_consumed" required>

            <label for="day">Day:</label>
            <input type="date" id="day" name="day" required>

            <button type="submit" name="submit">Send Workout</button>
            <button type="button" onclick="location.href='dashboard_trainer.php';">Back to Dashboard</button>

            <?php if (!empty($error)) { ?>
                <p class="error-message"><?php echo $error; ?></p>
            <?php } ?>

            <?php if (!empty($success)) { ?>
                <p class="success-message"><?php echo $success; ?></p>
            <?php } ?>
        </form>
    </div>
</body>
</html>
