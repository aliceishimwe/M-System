<?php
session_start();
include('../includes/db.php');

if (!isset($_SESSION['admin'])) {
    header('Location: ../index.php');
    exit();
}

// Fetch number of registered schools
$sql_schools = "SELECT COUNT(*) AS total_schools FROM Schools";
$result_schools = $conn->query($sql_schools);
$total_schools = $result_schools->fetch_assoc()['total_schools'];

// Fetch number of submitted projects
$sql_projects = "SELECT COUNT(*) AS total_projects FROM Projects";
$result_projects = $conn->query($sql_projects);
$total_projects = $result_projects->fetch_assoc()['total_projects'];

// Fetch current date
$current_date = date('Y-m-d');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1 class="header">Admin Dashboard</h1>
        <nav>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="manage_schools.php">Manage Schools</a></li>
                <li><a href="manage_projects.php">Manage Projects</a></li>
                <li><a href="settings.php">Settings</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </nav>
        <div class="number">
            <h2>Now Welcome to SWISS CONTACT as Admin You can seee more information</h2><br><br><br>
        <p>Number of registered schools: <?php echo $total_schools; ?></p>
        <p>Number of submitted projects: <?php echo $total_projects; ?></p>
        <p>Current date: <?php echo $current_date; ?></p>
        <br>
        <br>
        <form action="">
        <button class="dash"><a href="manage_projects.php">Get more >></a></button>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; niyonsenga felicien developer Keffa  </p>
    </footer>
</body>
</html>
