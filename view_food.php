<?php
// Include the database connection file
include 'db-config/connection.php';
session_start();

// Initialize variables for search functionality
$searchName = "";
$error_message = "";
$success_message = "";

// Fetch food items from the database
$query = "SELECT * FROM food_items";
$result = mysqli_query($con, $query);

// Process the search query
if(isset($_GET['search'])) {
    $searchName = $_GET['search'];
    // Modify the query to include the search filter
    $query .= " WHERE name LIKE '%$searchName%'";
    $result = mysqli_query($con, $query);
}

// Process delete action
if(isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Delete the food item from the database
    $delete_query = "DELETE FROM food_items WHERE id=$delete_id";
    if (mysqli_query($con, $delete_query)) {
        $success_message = "Food item deleted successfully!";
        // Refresh the page after deletion
        header("Refresh:0");
    } else {
        $error_message = "Error deleting food item: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Food</title>
    <style>
        /* General Styles */
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
            max-width: 1000px; /* Increase the maximum width of the container */
            width: 100%;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8); /* Add opacity to the background color */
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        h1 {
            text-align: center;
            margin-top: 0;
            margin-bottom: 20px;
            color: #333;
        }

        /* Form Styles */
        form {
            display: flex;
            margin-bottom: 20px;
        }

        input[type="text"] {
            flex: 1;
            padding: 10px;
            border-radius: 5px 0 0 5px;
            border: 1px solid #ccc;
            border-right: none;
        }

        button[type="submit"] {
            padding: 10px 20px;
            border: none;
            border-radius: 0 5px 5px 0;
            background-color: #4CAF50;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Table Styles */
        .table-container {
            max-height: 500px; /* Set the maximum height of the table container */
            overflow-y: auto; /* Add vertical scroll bar if needed */
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
            color: #333;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tbody tr:hover {
            background-color: #f2f2f2;
        }

        img {
            max-width: 100px;
        }

        /* Message Styles */
        .message {
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            margin-bottom: 20px;
        }

        .error-message {
            background-color: #f44336;
            color: white;
        }

        .success-message {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body style="background-image: url('background.jpg'); background-size: cover;">
    <div class="container">
        <h1>View Food</h1>

        <form action="" method="GET">
            <input type="text" name="search" placeholder="Search by name" value="<?php echo $searchName; ?>">
            <button type="submit">Search</button>
        </form>

        <div class="table-container"> <!-- Add a container for the table with scroll -->
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Stock</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['type']; ?></td>
                            <td><?php echo $row['stock']; ?></td>
                            <td><?php echo $row['price']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td><?php echo $row['description']; ?></td>
                            <td><?php echo isset($row['date']) ? $row['date'] : ''; ?></td>
                            <td><img src="<?php echo $row['image']; ?>" alt="Food Image"></td>
                            <td><a href="?delete_id=<?php echo $row['id']; ?>">Delete</a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <?php if ($error_message) { ?>
            <div class="message error-message"><?php echo $error_message; ?></div>
        <?php } ?>
        <?php if ($success_message) { ?>
            <div class="message success-message"><?php echo $success_message; ?></div>
        <?php } ?>
    </div>
</body>
</html>
