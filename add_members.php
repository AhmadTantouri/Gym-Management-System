<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Member</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        .member-container {
            width: calc(33.33% - 20px);
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        h3 {
            color: #333;
            margin-bottom: 15px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
        form {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        label {
            width: calc(50% - 10px);
            margin-bottom: 10px;
            font-weight: bold;
            color: #444;
        }
        input {
            width: calc(50% - 10px);
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-bottom: 15px;
            box-sizing: border-box;
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
            margin-left: auto;
            display: block;
        }
        button[type="submit"]:hover {
            background-color: #45a049;
        }
        .error-message,
        .success-message {
            position: absolute;
            bottom: -30px;
            left: 50%;
            transform: translateX(-50%);
            padding: 8px 16px;
            border-radius: 5px;
            font-size: 14px;
            font-weight: bold;
        }
        .error-message {
            background-color: #ff5252;
            color: #fff;
        }
        .success-message {
            background-color: #4CAF50;
            color: #fff;
        }
        .back-button {
            display: block;
            margin-top: 20px;
            padding: 10px 20px;
            background: linear-gradient(45deg, #333, #555);
            color: white;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            transition: background 0.3s, transform 0.3s;
        }
        .back-button:hover {
            background: linear-gradient(45deg, #555, #777);
            transform: scale(1.05);
        }
    </style>
</head>
<body style="background-image: url('background.jpg'); background-size: cover;">
    <div class="container">
        <div class="member-container" id="customer-container">
            <h3>Add Customer</h3>
            <form method="post" action="processes/process_customer.php">
                <label for="customer-first-name">First Name:</label>
                <input type="text" id="customer-first-name" name="customer-first-name" required>
                <label for="customer-last-name">Last Name:</label>
                <input type="text" id="customer-last-name" name="customer-last-name" required>
                <label for="customer-email">Email:</label>
                <input type="email" id="customer-email" name="customer-email" required>
                <label for="customer-phone">Phone:</label>
                <input type="tel" id="customer-phone" name="customer-phone" required>
                <label for="customer-address">Address:</label>
                <input type="text" id="customer-address" name="customer-address" required>
                <button type="submit">Add Customer</button>
            </form>
            <?php if(isset($_GET['error_message'])): ?>
                <div class="error-message"><?= $_GET['error_message'] ?></div>
            <?php endif; ?>
            <?php if(isset($_GET['success_message'])): ?>
                <div class="success-message"><?= $_GET['success_message'] ?></div>
            <?php endif; ?>
        </div>
        
        <div class="member-container" id="trainer-container">
            <h3>Add Trainer</h3>
            <form method="post" action="processes/process_trainer.php">
                <label for="trainer-first-name">First Name:</label>
                <input type="text" id="trainer-first-name" name="trainer-first-name" required>
                <label for="trainer-last-name">Last Name:</label>
                <input type="text" id="trainer-last-name" name="trainer-last-name" required>
                <label for="trainer-email">Email:</label>
                <input type="email" id="trainer-email" name="trainer-email" required>
                <label for="trainer-phone">Phone:</label>
                <input type="tel" id="trainer-phone" name="trainer-phone" required>
                <label for="trainer-address">Address:</label>
                <input type="text" id="trainer-address" name="trainer-address" required>
                <button type="submit">Add Trainer</button>
            </form>
            <?php if(isset($_GET['error_message'])): ?>
                <div class="error-message"><?= $_GET['error_message'] ?></div>
            <?php endif; ?>
            <?php if(isset($_GET['success_message'])): ?>
                <div class="success-message"><?= $_GET['success_message'] ?></div>
            <?php endif; ?>
        </div>

        <div class="member-container" id="dietitian-container">
            <h3>Add Dietitian</h3>
            <form method="post" action="processes/process_dietitian.php">
                <label for="dietitian-first-name">First Name:</label>
                <input type="text" id="dietitian-first-name" name="dietitian-first-name" required>
                <label for="dietitian-last-name">Last Name:</label>
                <input type="text" id="dietitian-last-name" name="dietitian-last-name" required>
                <label for="dietitian-email">Email:</label>
                <input type="email" id="dietitian-email" name="dietitian-email" required>
                <label for="dietitian-phone">Phone:</label>
                <input type="tel" id="dietitian-phone" name="dietitian-phone" required>
                <label for="dietitian-address">Address:</label>
                <input type="text" id="dietitian-address" name="dietitian-address" required>
                <button type="submit">Add Dietitian</button>
            </form>
            <?php if(isset($_GET['error_message'])): ?>
                <div class="error-message"><?= $_GET['error_message'] ?></div>
            <?php endif; ?>
            <?php if(isset($_GET['success_message'])): ?>
                <div class="success-message"><?= $_GET['success_message'] ?></div>
            <?php endif; ?>
        </div>

        <!-- Back button -->
        <a href="dashboard_admin.php" class="back-button">Back</a>
    </div>
</body>
</html>
