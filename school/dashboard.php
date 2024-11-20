<?php
session_start();
include('../includes/db.php');

if (!isset($_SESSION['school'])) {
    header('Location: ../index.php');
    exit();
}

// Fetch number of projects submitted by the school
$school_username = $_SESSION['school'];
$sql_school_id = "SELECT school_id FROM Schools WHERE Username='$school_username'";
$result_school_id = $conn->query($sql_school_id);
$school_id = $result_school_id->fetch_assoc()['school_id'];

$sql_projects = "SELECT COUNT(*) AS total_projects FROM Projects WHERE school_id='$school_id'";
$result_projects = $conn->query($sql_projects);
$total_projects = $result_projects->fetch_assoc()['total_projects'];

// Fetch current date
$current_date = date('Y-m-d');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>School Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>School Dashboard</h1>
        <nav>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="manage_projects.php">Manage Projects</a></li>
                <li><a href="settings.php">Settings</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </nav>
        <div class="number">
        <p>Number of projects submitted: <?php echo $total_projects; ?></p>
        <p>Current date: <?php echo $current_date; ?></p>
        <hr>
        <h2>Welcome school Manager here you can see you informatio</h2>
        <br>
        <h2>Manage your Project</h2>
        <br>
        <form action="">
        <button class="dash"><a href="manage_projects.php">Get more >></a></button>
        </form>

        <nav>
        </div>
            <ul>
                <li><a href="manage_projects.php">Manage Projects</a></li>
                <li><a href="settings.php">Settings</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </nav>
    </div>
    <footer class="footer">
        <p>&copy; niyonsenga felicien developer Keffa  </p>
    </footer>
</body>
</html>
