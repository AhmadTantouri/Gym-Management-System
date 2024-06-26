<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Member</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 10px;
            font-weight: bold;
        }
        input[type="text"] {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-bottom: 15px;
        }
        button[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            align-self: center;
        }
        button[type="submit"]:hover {
            background-color: #45a049;
        }
        p {
            text-align: center;
            margin-top: 20px;
            font-size: 16px;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
    <h2>Update Member</h2>
    <form method="post" action="process_update_member.php">
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id']) && isset($_GET['role'])) {
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "gym system";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $id = $_GET['id'];
            $role = $_GET['role'];
            $table = '';

            switch ($role) {
                case 'customer':
                    $table = 'customers';
                    break;
                case 'trainer':
                    $table = 'trainer';
                    break;
                case 'dietitian':
                    $table = 'dietitian';
                    break;
            }

            if ($table) {
                $sql = "SELECT * FROM $table WHERE id = $id";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    // Now you can display the form with the pre-populated data for editing
                    // Example:
                    foreach ($row as $key => $value) {
                        // Skip id and role fields
                        if ($key != 'id' && $key != 'role') {
                            echo "<label for='$key'>" . ucfirst(str_replace('_', ' ', $key)) . ":</label>";
                            echo "<input type='text' id='$key' name='$key' value='$value'><br><br>";
                        }
                    }
                    echo "<input type='hidden' name='id' value='{$row['id']}'>";
                    echo "<input type='hidden' name='role' value='$role'>";
                    echo "<button type='submit'>Update</button>";
                } else {
                    echo "Member not found.";
                }
            } else {
                echo "Invalid role specified.";
            }

            $conn->close();
        } else {
            echo "Invalid request method or parameters.";
        }
        ?>
    </form>
    </div>
</body>
</html>
