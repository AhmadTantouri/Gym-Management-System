<?php
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = ""; // Adjust as per your MySQL configuration
    $dbname = "gym system"; // Replace with your actual database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Handle file upload for exercise image
    $target_dir = "uploads/";
    // Ensure the target directory exists
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true); // Create the directory if it doesn't exist
    }

    $target_file = $target_dir . basename($_FILES["exercise_image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $maxFileSize = 500000; // 500 KB

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["exercise_image"]["tmp_name"]);
    if ($check === false) {
        die("File is not an image.");
    }

    // Check file size
    if ($_FILES["exercise_image"]["size"] > $maxFileSize) {
        die("Sorry, your file is too large. Maximum allowed size is " . ($maxFileSize / 1000) . " KB.");
    }

    // Allow certain file formats
    $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
    if (!in_array($imageFileType, $allowed_types)) {
        die("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
    }

    // Move uploaded file to destination directory
    if (!move_uploaded_file($_FILES["exercise_image"]["tmp_name"], $target_file)) {
        $error = $_FILES["exercise_image"]["error"];
        die("Sorry, there was an error uploading your file. Error code: $error");
    }

    // Sanitize inputs to prevent SQL injection
    $exercise_name = $conn->real_escape_string($_POST['exercise_name']);
    $description = $conn->real_escape_string($_POST['description']);
    $sets = intval($_POST['sets']);
    $reps = intval($_POST['reps']);
    $duration_minutes = intval($_POST['duration_minutes']);
    $image_path = $conn->real_escape_string($target_file);

    // Insert exercise details into database
    $sql = "INSERT INTO exercises (exercise_name, description, sets, reps, duration_minutes, image_path)
            VALUES ('$exercise_name', '$description', $sets, $reps, $duration_minutes, '$image_path')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Exercise added successfully!');</script>";
        // Redirect or display success message
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
