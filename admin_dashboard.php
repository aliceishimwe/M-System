<?php
session_start();
include('includes/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['admin_username'];
    $password = $_POST['admin_password'];
    
    $sql = "SELECT * FROM Users WHERE Username='$username' AND Password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['admin'] = $username;
        header('Location: admin/dashboard.php');
    } else {
        echo "Invalid login credentials";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Admin Dashboard</h1>
    <!-- Admin dashboard content here -->
</body>
</html>
