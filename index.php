<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body style="background-image: url('background.jpg'); background-size: cover;">

    <header style="background-color: #333; color: #fff; text-align: center; padding: 20px;">
        <h1>Welcome to Gym Management System</h1>
    </header>

    <div class="login-container">
        <h2>Login</h2>
        <form action="login.php" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
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
            <button type="submit">Login</button>
        </form>
    </div>

</body>
</html>
