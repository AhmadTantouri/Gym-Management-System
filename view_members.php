<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Members</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        .filter-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .filter-container select, .filter-container input {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .btn {
            padding: 8px 16px;
            margin: 0 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-update {
            background-color: #4CAF50;
            color: white;
        }
        .btn-delete {
            background-color: #f44336;
            color: white;
        }
        .back-button {
            display: block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #333;
            color: white;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
            margin-left: auto;
            margin-right: auto;
        }
        .back-button:hover {
            background-color: #555;
        }
    </style>
</head>
<body style="background-image: url('background.jpg'); background-size: cover;">
    <div class="container">
        <h2>View Members</h2>
        <div class="filter-container">
            <select id="member-type">
                <option value="all">All Members</option>
                <option value="customer">Customers</option>
                <option value="trainer">Trainers</option>
                <option value="dietitian">Dietitians</option>
            </select>
            <input type="text" id="search" placeholder="Search...">
        </div>
        <table id="members-table">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Specialty/Expertise</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
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

                // Fetch all customers
                $sql = "SELECT id, first_name, last_name, email, phone, 'customer' AS role, NULL AS specialty_expertise FROM customers
                        UNION
                        SELECT id, first_name, last_name, email, phone, 'trainer' AS role, specialty AS specialty_expertise FROM trainer
                        UNION
                        SELECT id, first_name, last_name, email, phone, 'dietitian' AS role, expertise AS specialty_expertise FROM dietitian";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr data-role='{$row['role']}' data-id='{$row['id']}'>";
                        echo "<td>{$row['first_name']}</td>";
                        echo "<td>{$row['last_name']}</td>";
                        echo "<td>{$row['email']}</td>";
                        echo "<td>{$row['phone']}</td>";
                        echo "<td>{$row['role']}</td>";
                        echo "<td>{$row['specialty_expertise']}</td>";
                        echo "<td><button class='btn btn-update' onclick='updateMember({$row['id']}, \"{$row['role']}\")'>Update</button><button class='btn btn-delete' onclick='deleteMember({$row['id']}, \"{$row['role']}\")'>Delete</button></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No members found</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
        <a href="dashboard_admin.php" class="back-button">Back</a>
    </div>
    <script>
        document.getElementById('member-type').addEventListener('change', function() {
            filterTable();
        });

        document.getElementById('search').addEventListener('input', function() {
            filterTable();
        });

        function filterTable() {
            const memberType = document.getElementById('member-type').value;
            const searchQuery = document.getElementById('search').value.toLowerCase();
            const rows = document.querySelectorAll('#members-table tbody tr');

            rows.forEach(row => {
                const role = row.getAttribute('data-role');
                const text = row.textContent.toLowerCase();

                const matchesType = memberType === 'all' || role === memberType;
                const matchesSearch = text.includes(searchQuery);

                if (matchesType && matchesSearch) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        function updateMember(id, role) {
            // Redirect to update page with member id and role
            window.location.href = `processes/update_member.php?id=${id}&role=${role}`;
        }

        function deleteMember(id, role) {
            if (confirm('Are you sure you want to delete this member?')) {
                // Create a form to submit the delete request
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = 'processes/delete_member.php';

                const inputId = document.createElement('input');
                inputId.type = 'hidden';
                inputId.name = 'id';
                inputId.value = id;
                form.appendChild(inputId);

                const inputRole = document.createElement('input');
                inputRole.type = 'hidden';
                inputRole.name = 'role';
                inputRole.value = role;
                form.appendChild(inputRole);

                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</body>
</html>
