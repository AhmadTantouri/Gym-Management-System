<?php
// Include the database connection file
include 'db-config/connection.php';
session_start();

// Fetch feedback from the database
$query = "SELECT * FROM feedback";
$result = mysqli_query($con, $query);

// Initialize an empty array to store feedback data
$feedback_data = [];

// Check if there are feedback records
if (mysqli_num_rows($result) > 0) {
    // Fetch each feedback record and store it in the feedback data array
    while ($row = mysqli_fetch_assoc($result)) {
        $feedback_data[] = $row;
    }
}

// Handle marking feedback as done functionality
if (isset($_GET['done_id'])) {
    $done_id = $_GET['done_id'];

    // Delete the feedback from the database
    $done_query = "DELETE FROM feedback WHERE id = $done_id";
    if (mysqli_query($con, $done_query)) {
        // Redirect to the same page after deletion
        header("Location: $_SERVER[PHP_SELF]");
        exit();
    } else {
        echo "Error marking feedback as done: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Feedback</title>
    <!-- Add your CSS styles here -->
    <style>
        /* General styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: transparent; /* Set body background color to transparent */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }


        .container {
            width: 80%;
            margin: 50px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent white background */
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }

        h2 {
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 28px;
            color: #333;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
            color: #333;
        }

        td {
            background-color: #fff;
            color: #444;
        }

        .button-column {
            width: 120px;
            text-align: center;
        }

        .button-column button {
            padding: 8px 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .button-column button:hover {
            background-color: #45a049;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #333;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .back-link:hover {
            background-color: #555;
        }
    </style>
</head>
<body style="background-image: url('background.jpg'); background-size: cover;">
    <div class="container">
        <h2>View Feedback</h2>
        <!-- Feedback table -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer ID</th>
                    <th>Feedback Type</th>
                    <th>Message</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($feedback_data as $feedback) { ?>
                    <tr>
                        <td><?php echo $feedback['id']; ?></td>
                        <td><?php echo $feedback['customer_username']; ?></td>
                        <td><?php echo $feedback['feedback_type']; ?></td>
                        <td><?php echo $feedback['message']; ?></td>
                        <td><?php echo date('M d, Y', strtotime($feedback['created_at'])); ?></td>
                        <td class="button-column">
                            <a href="?done_id=<?php echo $feedback['id']; ?>">
                                <button>Done</button>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <!-- Back link -->
        <a href="dashboard_admin.php" class="back-link">Back</a>
    </div>
</body>
</html>
