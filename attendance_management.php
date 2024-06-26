<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Management</title>
    <style>
        /* Add your CSS styles here */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: rgba(244, 244, 244, 0.9);
            /* Transparent white background */
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            /* Transparent white background */
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-top: 0;
            color: #333;
        }

        form label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        form select,
        form input[type="date"] {
            width: calc(100% - 12px);
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        form button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        form button:hover {
            background-color: #45a049;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th,
        table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
        }

        .delete-btn {
            background-color: #f44336;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 8px 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .delete-btn:hover {
            background-color: #da190b;
        }

        .message {
            padding: 10px;
            margin-top: 10px;
            border-radius: 4px;
            text-align: center;
        }

        .error-message {
            background-color: #f44336;
            color: #fff;
        }

        .success-message {
            background-color: #4CAF50;
            color: #fff;
        }

        /* Custom styles for enhanced design */
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
            background-color: rgba(255, 255, 255, 0.7);
            /* Transparent white background */
        }

        input[type="text"]:focus {
            outline: none;
            border-color: #4CAF50;
        }

        .search-container {
            margin-bottom: 20px;
        }

        .search-icon {
            position: relative;
            left: -30px;
            top: 3px;
            color: #aaa;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .search-icon:hover {
            color: #555;
        }

        /* Back Button Style */
.back-btn {
    padding: 10px 20px;
    background-color: #333;
    color: #fff;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
    text-decoration: none; /* Remove underline from anchor tag */
    transition: background-color 0.3s ease;
    margin-bottom: 20px; /* Adjust margin as needed */
    display: inline-block;
}

.back-btn:hover {
    background-color: #555;
}

    </style>
</head>

<body style="background-image: url('background.jpg'); background-size: cover;">
    <div class="container">
        <h2>Add Attendance</h2>
        <?php
        // Include the database connection file
        $con = mysqli_connect("localhost", "root", "", "gym system");

        // Initialize variables to store success and error messages
        $error_message = '';
        $success_message = '';

        // Fetch customers
        $customer_query = "SELECT id, first_name, last_name FROM customers";
        $customer_result = mysqli_query($con, $customer_query);

        // Fetch trainers
        $trainer_query = "SELECT id, first_name, last_name FROM trainer";
        $trainer_result = mysqli_query($con, $trainer_query);

        // Fetch dietitians
        $dietitian_query = "SELECT id, first_name, last_name FROM dietitian";
        $dietitian_result = mysqli_query($con, $dietitian_query);

        // Process the form submission to add attendance
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_attendance'])) {
            $member_type = $_POST['member_type'];
            $member_id = $_POST['member_id'];
            $date = $_POST['date'];
            $status = $_POST['status'];

            // Insert the attendance record into the database
            $insert_query = "INSERT INTO attendance (member_type, member_id, date, status) VALUES ('$member_type', '$member_id', '$date', '$status')";
            if (mysqli_query($con, $insert_query)) {
                $success_message = "Attendance added successfully!";
            } else {
                $error_message = "Error adding attendance: " . mysqli_error($con);
            }
        }

        // Process the delete request
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_attendance'])) {
            $id = $_POST['id'];

            // Delete the attendance record from the database
            $delete_query = "DELETE FROM attendance WHERE id = '$id'";
            if (mysqli_query($con, $delete_query)) {
                $success_message = "Attendance deleted successfully!";
            } else {
                $error_message = "Error deleting attendance: " . mysqli_error($con);
            }
        }
        ?>
        <form method="post" action="">
            <input type="hidden" name="add_attendance" value="1">
            <label for="member_type">Member Type:</label>
            <select id="member_type" name="member_type" onchange="populateMembers()">
                <option value="customer">Customer</option>
                <option value="trainer">Trainer</option>
                <option value="dietitian">Dietitian</option>
            </select>
            <label for="member_id">Member:</label>
            <select id="member_id" name="member_id">
                <!-- Options will be populated dynamically based on the selected role -->
            </select>
            <label for="date">Date:</label>
            <input type="date" id="date" name="date">
            <label for="status">Status:</label>
            <select id="status" name="status">
                <option value="present">Present</option>
                <option value="absent">Absent</option>
            </select>
            <button type="submit">Add</button>
        </form>

        <?php if ($error_message) { ?>
            <div class="message error-message"><?php echo $error_message; ?></div>
        <?php } ?>
        <?php if ($success_message) { ?>
            <div class="message success-message"><?php echo $success_message; ?></div>
        <?php } ?>

        <div class="search-container">
            <input type="text" id="searchInput" placeholder="Search...">
            <i class="search-icon">🔍</i>
        </div>

        <h2>View Attendance</h2>
        <table id="attendanceTable">
            <thead>
                <tr>
                    <th>Member Type</th>
                    <th>Member Name</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch and display attendance records from the database
                $query = "SELECT attendance.*, customers.first_name AS customer_first_name, customers.last_name AS customer_last_name, trainer.first_name AS trainer_first_name, trainer.last_name AS trainer_last_name, dietitian.first_name AS dietitian_first_name, dietitian.last_name AS dietitian_last_name FROM attendance LEFT JOIN customers ON attendance.member_id = customers.id AND attendance.member_type = 'customer' LEFT JOIN trainer ON attendance.member_id = trainer.id AND attendance.member_type = 'trainer' LEFT JOIN dietitian ON attendance.member_id = dietitian.id AND attendance.member_type = 'dietitian'";
                $result = mysqli_query($con, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                    // Display each attendance record in a table row
                    echo "<tr>";
                    echo "<td>{$row['member_type']}</td>";
                    echo "<td>";
                    switch ($row['member_type']) {
                        case 'customer':
                            echo $row['customer_first_name'] . ' ' . $row['customer_last_name'];
                            break;
                        case 'trainer':
                            echo $row['trainer_first_name'] . ' ' . $row['trainer_last_name'];
                            break;
                        case 'dietitian':
                            echo $row['dietitian_first_name'] . ' ' . $row['dietitian_last_name'];
                            break;
                        default:
                            echo '-';
                            break;
                    }
                    echo "</td>";
                    echo "<td>{$row['date']}</td>";
                    echo "<td>{$row['status']}</td>";
                    echo "<td>
                        <form method='post' action='' style='display:inline-block;'>
                            <input type='hidden' name='delete_attendance' value='1'>
                            <input type='hidden' name='id' value='{$row['id']}'>
                            <button type='submit' class='delete-btn'>Delete</button>
                        </form>
                    </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <!-- Add Back Button at the bottom of the container -->
        <a href="javascript:history.back()" class="back-btn">Back</a>

    </div>
    <script>
        function populateMembers() {
            var memberType = document.getElementById("member_type").value;
            var memberSelect = document.getElementById("member_id");
            memberSelect.innerHTML = ""; // Clear previous options

            // Fetch members based on the selected role
            switch (memberType) {
                case "customer":
                    <?php while ($row = mysqli_fetch_assoc($customer_result)) { ?>
                        var option = document.createElement("option");
                        option.value = "<?php echo $row['id']; ?>";
                        option.text = "<?php echo $row['first_name'] . ' ' . $row['last_name']; ?>";
                        memberSelect.appendChild(option);
                    <?php } ?>
                    break;
                case "trainer":
                    <?php while ($row = mysqli_fetch_assoc($trainer_result)) { ?>
                        var option = document.createElement("option");
                        option.value = "<?php echo $row['id']; ?>";
                        option.text = "<?php echo $row['first_name'] . ' ' . $row['last_name']; ?>";
                        memberSelect.appendChild(option);
                    <?php } ?>
                    break;
                case "dietitian":
                    <?php while ($row = mysqli_fetch_assoc($dietitian_result)) { ?>
                        var option = document.createElement("option");
                        option.value = "<?php echo $row['id']; ?>";
                        option.text = "<?php echo $row['first_name'] . ' ' . $row['last_name']; ?>";
                        memberSelect.appendChild(option);
                    <?php } ?>
                    break;
                default:
                    break;
            }
        }
        // Populate members initially
        populateMembers();

        // Search functionality
        document.getElementById("searchInput").addEventListener("keyup", function() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("attendanceTable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1]; // Filter based on the second column (Member Name)
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        });
    </script>
</body>

</html>
