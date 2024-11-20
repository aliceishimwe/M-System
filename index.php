<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Swiss Contact</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Welcome to Swiss Contact</h1>
        <div class="login-form">
        <div class="login">
            <h2>Admin Login</h2>
            <form action="admin_dashboard.php" method="post">
                <input type="text" name="admin_username" placeholder="Username" required autocomplete="off">
                <input type="password" name="admin_password" placeholder="Password" required autocomplete="off">
                <button type="submit">Login</button>
            </form>
        </div>
        <div class="login">
            <h2>School Login</h2>
            <form action="school_dashboard.php" method="post">
                <input type="text" name="school_username" placeholder="Username" required autocomplete="off">
                <input type="password" name="school_password" placeholder="Password" required autocomplete="off">
                <button type="submit">Login</button>
            </form>
        </div>
        </div>
       
    </div>
</body>
</html>
