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

// Initialize variables
$timeConflict = false;
$classInserted = false;

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $className = $_POST['class_name'];
    $classDate = $_POST['class_date'];
    $classTime = $_POST['class_time'];
    $classDuration = $_POST['class_duration'];

    // Check for time conflicts
    $checkConflictSql = "SELECT * FROM classes WHERE class_date = '$classDate' AND class_time = '$classTime'";
    $result = $conn->query($checkConflictSql);

    if ($result->num_rows > 0) {
        $timeConflict = true;
    } else {
        // Insert the new class into the database
        $insertSql = "INSERT INTO classes (class_name, class_date, class_time, class_duration) VALUES ('$className', '$classDate', '$classTime', '$classDuration')";

        if ($conn->query($insertSql) === TRUE) {
            $classInserted = true;
        }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Class</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('background.jpg');
            background-size: cover;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8); /* Adjust the alpha value to make it more or less transparent */
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="text"],
        input[type="date"],
        input[type="time"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        button[type="submit"], button[type="button"] {
            width: 48%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            margin-top: 10px;
        }

        button[type="submit"]:hover, button[type="button"]:hover {
            background-color: #45a049;
        }

        .error-message {
            color: red;
            margin-top: 10px;
            text-align: center;
        }

        .success-message {
            color: green;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add New Class</h2>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if ($timeConflict) {
                echo "<p class='error-message'>Time conflict! Class cannot be added.</p>";
            } else {
                if ($classInserted) {
                    echo "<p class='success-message'>New class added successfully!</p>";
                } else {
                    echo "<p class='error-message'>Error adding class. Please try again.</p>";
                }
            }
        }
        ?>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for="class_name">Class Name:</label>
            <input type="text" id="class_name" name="class_name" required>

            <label for="class_date">Class Date:</label>
            <input type="date" id="class_date" name="class_date" required>

            <label for="class_time">Class Time:</label>
            <input type="time" id="class_time" name="class_time" required>

            <label for="class_duration">Class Duration (in minutes):</label>
            <input type="number" id="class_duration" name="class_duration" required>

            <button type="submit">Add Class</button>
            <button type="button" onclick="location.href='dashboard_trainer.php';">Back to Dashboard</button>
        </form>
    </div>
</body>
</html>
