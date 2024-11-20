<?php
session_start();
include('includes/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['school_username'];
    $password = $_POST['school_password'];
    
    $sql = "SELECT * FROM Schools WHERE Username='$username' AND Password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['school'] = $username;
        header('Location: school/dashboard.php');
    } else {
        echo "Invalid login credentials";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>School Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>School Dashboard</h1>
    <!-- School dashboard content here -->
</body>
</html>
