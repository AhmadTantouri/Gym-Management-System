<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Meal Plan</title>
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
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-weight: 500;
        }

        /* Meal plan card styles */
        .meal-plan-card {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease-in-out;
        }

        .meal-plan-card:hover {
            transform: translateY(-5px);
        }

        .meal-plan-card h3 {
            color: #333;
            margin-top: 0;
            font-size: 22px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
        }

        .meal-plan-card p {
            margin: 10px 0;
            color: #666;
            font-size: 16px;
        }

        .meal-plan-card p strong {
            color: #333;
        }

        .meal-container {
            margin-bottom: 20px;
        }

        .meal-container img {
            max-width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .total-calories-container {
            background-color: #e9e9e9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,            0, 0, 0, 0.1);
            text-align: center;
            font-size: 18px;
            color: #333;
            margin-top: 20px;
        }

        .done-btn {
            display: block;
            width: 100%;
            padding: 12px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-align: center;
            margin-top: 20px;
            transition: background-color 0.3s;
        }

        .done-btn:hover {
            background-color: #218838;
        }

        /* Error message styles */
        .error-message {
            color: #dc3545;
            margin-top: 20px;
            text-align: center;
            font-size: 18px;
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
        <h2>View Meal Plan</h2>
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

        // Handle the deletion request
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['meal_plan_id'])) {
            $meal_plan_id = $_POST['meal_plan_id'];
            $delete_sql = "DELETE FROM meal_plans WHERE id = '$meal_plan_id'";
            if ($conn->query($delete_sql) === TRUE) {
                echo "<p class='success-message'>Meal plan marked as done and deleted successfully.</p>";
            } else {
                echo "<p class='error-message'>Error deleting meal plan: " . $conn->error . "</p>";
            }
        }

        // Fetch meal plan for the logged-in customer
        $sql_meal_plan = "SELECT * FROM meal_plans WHERE customer_username = '$loggedInUsername'";
        $result_meal_plan = $conn->query($sql_meal_plan);

        // Check if there is a meal plan for the logged-in customer
        if ($result_meal_plan->num_rows > 0) {
            // Display the meal plan
            while ($row_meal_plan = $result_meal_plan->fetch_assoc()) {
                echo "<div class='meal-plan-card'>";
                echo "<h3>Meal Plan for {$row_meal_plan['customer_username']}</h3>";
                echo "<p><strong>Date:</strong> {$row_meal_plan['meal_date']}</p>";

                echo "<div class='meal-container'>";
                echo "<h4>Breakfast</h4>";
                echo "<img src='{$row_meal_plan['breakfast_image']}' alt='Breakfast' class='meal-image'>";
                echo "<p><strong>Description:</strong> {$row_meal_plan['breakfast']}</p>";
                echo "<p><strong>Calories:</strong> {$row_meal_plan['breakfast_calories']} kcal</p>";
                echo "</div>";

                echo "<div class='meal-container'>";
                echo "<h4>Lunch</h4>";
                echo "<img src='{$row_meal_plan['lunch_image']}' alt='Lunch' class='meal-image'>";
                echo "<p><strong>Description:</strong> {$row_meal_plan['lunch']}</p>";
                echo "<p><strong>Calories:</strong> {$row_meal_plan['lunch_calories']} kcal</p>";
                echo "</div>";

                echo "<div class='meal-container'>";
                echo "<h4>Dinner</h4>";
                echo "<img src='{$row_meal_plan['dinner_image']}' alt='Dinner' class='meal-image'>";
                echo "<p><strong>Description:</strong> {$row_meal_plan['dinner']}</p>";
                echo "<p><strong>Calories:</strong> {$row_meal_plan['dinner_calories']} kcal</p>";
                echo "</div>";

                echo "<div class='meal-container'>";
                echo "<h4>Snacks</h4>";
                echo "<img src='{$row_meal_plan['snacks_image']}' alt='Snacks' class='meal-image'>";
                echo "<p><strong>Description:</strong> {$row_meal_plan['snacks']}</p>";
                echo "<p><strong>Calories:</strong> {$row_meal_plan['snacks_calories']} kcal</p>";
                echo "</div>";

                echo "<div class='total-calories-container'>";
                echo "<p><strong>Total Calories Consumed:</strong> {$row_meal_plan['total_calories_consumed']} kcal</p>";
                echo "</div>";

                echo "<form method='post' action=''>";
                echo "<input type='hidden' name='meal_plan_id' value='{$row_meal_plan['id']}'>";
                echo "<button type='submit' class='done-btn'>Done</button>";
                echo "</form>";

                echo "</div>";
            }
        } else {
            // No meal plan found for the logged-in customer
            echo "<p class='error-message'>No meal plan found for this customer.</p>";
        }

        $conn->close();
        ?>
        
        <a href="dashboard_customer.php" class="back-btn">Back to Dashboard</a>
    </div>
</body>
</html>

