<?php
// Include the database connection file
include 'db-config/connection.php';
session_start();

// Function to add a new user
if (isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Check if the username is already taken
    $check_query = "SELECT * FROM user_account WHERE username='$username'";
    $check_result = mysqli_query($con, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $error_message = "Username already exists!";
    } else {
        // Insert the new user into the database
        $insert_query = "INSERT INTO user_account (username, password, role) VALUES ('$username', '$password', '$role')";
        if (mysqli_query($con, $insert_query)) {
            $success_message = "User added successfully!";
        } else {
            $error_message = "Error adding user: " . mysqli_error($con);
        }
    }
}

// Function to delete a user
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Delete related feedback first
    $delete_feedback_query = "DELETE FROM feedback WHERE customer_username = (SELECT username FROM user_account WHERE id=$delete_id)";
    mysqli_query($con, $delete_feedback_query);

    // Delete the user from the database
    $delete_user_query = "DELETE FROM user_account WHERE id=$delete_id";
    if (mysqli_query($con, $delete_user_query)) {
        $success_message = "User and related feedback deleted successfully!";
    } else {
        $error_message = "Error deleting user: " . mysqli_error($con);
    }
}

// Fetch users from the database
$query = "SELECT * FROM user_account";
$result = mysqli_query($con, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($con));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" type="text/css" href="manage_users.css">
    <style>
        /* Manage Users Styles */
        .manage-users-container {
            width: 80%;
            margin: 50px auto;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }

        .manage-users-container h2 {
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
            text-align: center;
        }

        .manage-users-form {
            text-align: center;
        }

        .manage-users-form .form-group {
            margin-bottom: 20px;
        }

        .manage-users-form label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }

        .manage-users-form input[type="text"],
        .manage-users-form input[type="password"],
        .manage-users-form select {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .manage-users-form button[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .manage-users-form button[type="submit"]:hover {
            background-color: #45a049;
        }

        .manage-users-table {
            width: 100%;
            border-collapse: collapse;
        }

        .manage-users-table th, .manage-users-table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
            color: #333;
        }

        .manage-users-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .manage-users-message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 3px;
        }

        .manage-users-error-message {
            background-color: #f44336;
            color: white;
        }

        .manage-users-success-message {
            background-color: #4CAF50;
            color: white;
        }

        .back-button, .delete-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #333;
            color: white;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
            cursor: pointer;
        }

        .back-button:hover, .delete-button:hover {
            background-color: #555;
        }

        .delete-button {
            background-color: #f44336;
            margin-left: 10px;
        }

        .delete-button:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body style="background-image: url('background.jpg'); background-size: cover;">
    <div class="manage-users-container">
        <h2>Manage Users</h2>

        <!-- Display error or success messages -->
        <?php if (isset($error_message)) { ?>
            <div class="manage-users-message manage-users-error-message"><?php echo $error_message; ?></div>
        <?php } ?>
        <?php if (isset($success_message)) { ?>
            <div class="manage-users-message manage-users-success-message"><?php echo $success_message; ?></div>
        <?php } ?>

        <!-- User addition form -->
        <form class="manage-users-form" method="post" action="">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="role">Role:</label>
                <select id="role" name="role">
                    <option value="admin">Admin</option>
                    <option value="customer">Customer</option>
                    <option value="trainer">Trainer</option>
                    <option value="dietitian">Dietitian</option>
                </select>
            </div>
            <button type="submit" name="add_user">Add User</button>
        </form>

        <!-- User table -->
        <table class="manage-users-table">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo $row['role']; ?></td>
                        <td>
                            <a href="?delete_id=<?php echo $row['id']; ?>" class="delete-button" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Back button -->
        <a href="dashboard_admin.php" class="back-button">Back</a>
    </div>
</body>
</html>
