<?php
// Include the database connection file
include 'db-config/connection.php';
session_start();

// Initialize variables to store success and error messages
$error_message = '';
$success_message = '';

// Process the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $type = $_POST['type'];
    $stock = $_POST['stock'];
    $price = $_POST['price'];
    $status = $_POST['status'];
    $description = $_POST['description'];
    $date_added = $_POST['date_added'];

    // Handle image upload
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif") {
            $error_message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                // Insert the food item into the database
                $insert_query = "INSERT INTO food_items (name, type, stock, price, status, description, date, image) 
                 VALUES ('$name', '$type', '$stock', '$price', '$status', '$description', NOW(), '$targetFile')";

                if (mysqli_query($con, $insert_query)) {
                    $success_message = "Food item added successfully!";
                } else {
                    $error_message = "Error adding food item: " . mysqli_error($con);
                }
            } else {
                $error_message = "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        $error_message = "File is not an image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Food</title>
    <!-- Add your CSS styles here -->
    <style>
        /* Add your CSS styles for the page layout, form, error/success messages, etc. */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: transparent; /* Set body background color to transparent */
        }

        .container {
            width: 50%;
            margin: 50px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8); /* Add opacity to the background color */
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }

        h2 {
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="text"],
        input[type="number"],
        textarea,
        select {
            width: calc(100% - 22px);
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        textarea {
            height: 100px;
        }

        input[type="file"] {
            margin-top: 5px;
        }

        button[type="submit"] {
            padding: 12px 20px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        .error-message,
        .success-message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 3px;
            text-align: center;
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
        <h2>Add Food</h2>
        <!-- Form -->
        <form method="post" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="type">Type:</label>
                <select id="type" name="type" required>
                    <option value="meals">Meals</option>
                    <option value="drinks">Drinks</option>
                    <option value="snacks">Snacks</option>
                    <!-- Add more options for other types -->
                </select>
            </div>
            <div class="form-group">
                <label for="stock">Stock:</label>
                <input type="number" id="stock" name="stock" required>
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" id="price" name="price" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select id="status" name="status" required>
                    <option value="available">Available</option>
                    <option value="non-available">Non-Available</option>
                </select>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" required></textarea>
            </div>
            <div class="form-group">
                <label for="image">Image:</label>
                <input type="file" id="image" name="image" accept="image/*" required>
            </div>
            <!-- Hidden input field for date added -->
            <div class="form-group">
                <input type="hidden" id="date_added" name="date_added" value="<?php echo date('Y-m-d'); ?>">
            </div>
            <button type="submit">Add Food</button>
        </form>
        <!-- Error and success messages -->
        <?php if ($error_message) { ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php } ?>
        <?php if ($success_message) { ?>
            <div class="success-message"><?php echo $success_message; ?></div>
        <?php } ?>
    </div>
</body>
</html>
