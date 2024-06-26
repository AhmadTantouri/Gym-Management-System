<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Meal Plan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('background.jpg');
            margin: 0;
            background-size: cover;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .full-width {
            grid-column: span 2;
        }

        .section {
            background-color: rgba(240, 240, 240, 0.9);
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .section h3 {
            margin-top: 0;
            color: #333;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
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
            margin-bottom: 15px;
            box-sizing: border-box;
            background-color: #f8f9fa;
            color: #555;
        }

        textarea {
            resize: vertical;
        }

        button[type="submit"],
        .back-button {
            width: 100%;
            padding: 12px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }

        button[type="submit"]:hover,
        .back-button:hover {
            background-color: #218838;
        }

        .error-message {
            color: #dc3545;
            margin-top: 10px;
        }

        .success-message {
            color: #28a745;
            margin-top: 10px;
        }

        .total-calories {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            color: #333;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Send Meal Plan</h2>
        <!-- Form to add meal plans -->
        <form id="mealPlanForm" method="post" enctype="multipart/form-data">
            <div class="section full-width">
                <h3>General Information</h3>
                <label for="dietitian_username">Dietitian Username:</label>
                <input type="text" id="dietitian_username" name="dietitian_username" required>

                <label for="customer_username">Customer Username:</label>
                <select id="customer_username" name="customer_username" required>
                    <?php
                    // PHP code to fetch and populate customer usernames in dropdown
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "gym system";

                    $conn = new mysqli($servername, $username, $password, $dbname);

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Fetch customer usernames from user_account table where role is customer
                    $sql = "SELECT username FROM user_account WHERE role = 'customer'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['username'] . "'>" . $row['username'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No customers found</option>";
                    }

                    $conn->close();
                    ?>
                </select>

                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required>
            </div>

            <div class="grid">
                <div class="section">
                    <h3>Breakfast</h3>
                    <label for="breakfast">Description:</label>
                    <textarea id="breakfast" name="breakfast" required></textarea>

                    <label for="breakfast_calories">Calories:</label>
                    <input type="number" id="breakfast_calories" name="breakfast_calories" required>

                    <label for="breakfast_image">Image:</label>
                    <input type="file" id="breakfast_image" name="breakfast_image" accept="image/*" required>
                </div>

                <div class="section">
                    <h3>Lunch</h3>
                    <label for="lunch">Description:</label>
                    <textarea id="lunch" name="lunch" required></textarea>

                    <label for="lunch_calories">Calories:</label>
                    <input type="number" id="lunch_calories" name="lunch_calories" required>

                    <label for="lunch_image">Image:</label>
                    <input type="file" id="lunch_image" name="lunch_image" accept="image/*" required>
                </div>

                <div class="section">
                    <h3>Dinner</h3>
                    <label for="dinner">Description:</label>
                    <textarea id="dinner" name="dinner" required></textarea>

                    <label for="dinner_calories">Calories:</label>
                    <input type="number" id="dinner_calories" name="dinner_calories" required>

                    <label for="dinner_image">Image:</label>
                    <input type="file" id="dinner_image" name="dinner_image" accept="image/*" required>
                </div>

                <div class="section">
                    <h3>Snacks</h3>
                    <label for="snacks">Description:</label>
                    <textarea id="snacks" name="snacks" required></textarea>

                    <label for="snacks_calories">Calories:</label>
                    <input type="number" id="snacks_calories" name="snacks_calories" required>

                    <label for="snacks_image">Image:</label>
                    <input type="file" id="snacks_image" name="snacks_image" accept="image/*" required>
                </div>
            </div>

            <!-- Total Calories Consumed will be calculated automatically -->
            <input type="hidden" id="total_calories_consumed" name="total_calories_consumed" value="">

            <div class="total-calories" id="totalCaloriesDisplay">Total Calories: 0</div>

            <button type="submit">Add Meal Plan</button>
        </form>

        <!-- Back button -->
        <a href="dashboard_dietitian.php" class="back-button">Back to Dashboard</a>

        <?php
        // PHP code to handle form submission and database insertion
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "gym system";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Retrieve form data
            $dietitian_username = $_POST['dietitian_username'];
            $customer_username = $_POST['customer_username'];
            $date = $_POST['date'];
            $breakfast = $_POST['breakfast'];
            $breakfast_calories = $_POST['breakfast_calories'];
            $lunch = $_POST['lunch'];
            $lunch_calories = $_POST['lunch_calories'];
            $dinner = $_POST['dinner'];
            $dinner_calories = $_POST['dinner_calories'];
            $snacks = $_POST['snacks'];
            $snacks_calories = $_POST['snacks_calories'];
            $total_calories_consumed = $breakfast_calories + $lunch_calories + $dinner_calories + $snacks_calories;

            // Upload images and get file paths
            $uploadDir = 'uploads/';
            $breakfast_image_path = $uploadDir . basename($_FILES["breakfast_image"]["name"]);
            $lunch_image_path = $uploadDir . basename($_FILES["lunch_image"]["name"]);
            $dinner_image_path = $uploadDir . basename($_FILES["dinner_image"]["name"]);
            $snacks_image_path = $uploadDir . basename($_FILES["snacks_image"]["name"]);

            // Move uploaded files to the upload directory
            move_uploaded_file($_FILES["breakfast_image"]["tmp_name"], $breakfast_image_path);
            move_uploaded_file($_FILES["lunch_image"]["tmp_name"], $lunch_image_path);
            move_uploaded_file($_FILES["dinner_image"]["tmp_name"], $dinner_image_path);
            move_uploaded_file($_FILES["snacks_image"]["tmp_name"], $snacks_image_path);

            // Insert into database
            $sql = "INSERT INTO meal_plans (dietitian_username, customer_username, meal_date, breakfast, breakfast_calories, breakfast_image, lunch, lunch_calories, lunch_image, dinner, dinner_calories, dinner_image, snacks, snacks_calories, snacks_image, total_calories_consumed)
            VALUES ('$dietitian_username', '$customer_username', '$date', '$breakfast', '$breakfast_calories', '$breakfast_image_path', '$lunch', '$lunch_calories', '$lunch_image_path', '$dinner', '$dinner_calories', '$dinner_image_path', '$snacks', '$snacks_calories', '$snacks_image_path', '$total_calories_consumed')";

            if ($conn->query($sql) === TRUE) {
                echo "<p class='success-message'>New record created successfully</p>";
            } else {
                echo "<p class='error-message'>Error: " . $sql . "<br>" . $conn->error . "</p>";
            }

            $conn->close();
        }
        ?>
    </div>

    <!-- Script for calculating total calories consumed and updating the display -->
    <script>
        document.getElementById('mealPlanForm').addEventListener('submit', function(event) {
            // Calculate total calories consumed
            var breakfastCalories = parseInt(document.getElementById('breakfast_calories').value) || 0;
            var lunchCalories = parseInt(document.getElementById('lunch_calories').value) || 0;
            var dinnerCalories = parseInt(document.getElementById('dinner_calories').value) || 0;
            var snacksCalories = parseInt(document.getElementById('snacks_calories').value) || 0;
            var totalCalories = breakfastCalories + lunchCalories + dinnerCalories + snacksCalories;

            // Set total calories consumed value
            document.getElementById('total_calories_consumed').value = totalCalories;

            // Update total calories display
            document.getElementById('totalCaloriesDisplay').textContent = "Total Calories: " + totalCalories;
        });

        // Recalculate and update total calories display on input change
        document.querySelectorAll('input[type="number"]').forEach(function(input) {
            input.addEventListener('input', function() {
                var breakfastCalories = parseInt(document.getElementById('breakfast_calories').value) || 0;
                var lunchCalories = parseInt(document.getElementById('lunch_calories').value) || 0;
                var dinnerCalories = parseInt(document.getElementById('dinner_calories').value) || 0;
                var snacksCalories = parseInt(document.getElementById('snacks_calories').value) || 0;
                var totalCalories = breakfastCalories + lunchCalories + dinnerCalories + snacksCalories;

                document.getElementById('totalCaloriesDisplay').textContent = "Total Calories: " + totalCalories;
            });
        });
    </script>
</body>

</html>
