<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Classes</title>
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
            background-color: #f2f2f2;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-weight: 500;
        }

        /* Class card styles */
        .class-card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            overflow: hidden;
            transition: transform 0.3s;
        }

        .class-card:hover {
            transform: translateY(-5px);
        }

        .class-info {
            padding: 20px;
        }

        .class-name {
            font-size: 24px;
            font-weight: 500;
            margin-bottom: 10px;
        }

        .class-details {
            color: #666;
            margin-bottom: 15px;
        }

        .class-date {
            margin-right: 20px;
        }

        .class-time {
            margin-right: 20px;
        }

        .class-duration {
            margin-right: 20px;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 10px 15px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-align: center;
            transition: background-color 0.3s;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Available Classes</h2>
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

        // Query to fetch available classes
        $sql = "SELECT * FROM classes";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<div class='class-card'>";
                echo "<div class='class-info'>";
                echo "<div class='class-name'>" . $row['class_name'] . "</div>";
                echo "<div class='class-details'>";
                echo "<span class='class-date'>Date: " . $row['class_date'] . "</span>";
                echo "<span class='class-time'>Time: " . $row['class_time'] . "</span>";
                echo "<span class='class-duration'>Duration: " . $row['class_duration'] . " minutes</span>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p>No classes available</p>";
        }

        // Close connection
        $conn->close();
        ?>
        <a href="dashboard_customer.php" class="btn">Back to Dashboard</a>
    </div>
</body>

</html>
