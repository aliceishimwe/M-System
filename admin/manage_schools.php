<?php
session_start();
include('../includes/db.php');

if (!isset($_SESSION['admin'])) {
    header('Location: ../index.php');
    exit();
}
// Fetch list of schools with search functionality
$search_query = "";
if (isset($_POST['search'])) {
    $search_query = $_POST['search_query'];
}

$sql_schools = "SELECT * FROM Schools WHERE School_name LIKE '%$search_query%' OR District LIKE '%$search_query%' OR Sector LIKE '%$search_query%'";
$result_schools = $conn->query($sql_schools);

// Handle add, edit, delete, and revoke/grant operations
if (isset($_POST['action'])) {
    $action = $_POST['action'];
    
    if ($action == 'add') {
        $school_name = $_POST['school_name'];
        $district = $_POST['district'];
        $sector = $_POST['sector'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        // $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $sql = "INSERT INTO Schools (School_name, District, Sector, Phone, Email, Username, Password)
                VALUES ('$school_name', '$district', '$sector', '$phone', '$email', '$username', '$password')";
        $conn->query($sql);
    } elseif ($action == 'delete') {
        $school_id = $_POST['school_id'];
        $sql = "DELETE FROM Schools WHERE school_id='$school_id'";
        $conn->query($sql);
    } elseif ($action == 'revoke' || $action == 'grant') {
        $school_id = $_POST['school_id'];
        $status = ($action == 'revoke') ? 0 : 1;
        $sql = "UPDATE Schools SET status='$status' WHERE school_id='$school_id'";
        $conn->query($sql);
    }
}

// Fetch list of schools
$sql_schools = "SELECT * FROM Schools";
$result_schools = $conn->query($sql_schools);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Schools</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Manage Schools</h1>
        <nav>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="manage_schools.php">Manage Schools</a></li>
                <li><a href="manage_projects.php">Manage Projects</a></li>
                <li><a href="settings.php">Settings</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </nav>
        <form action="manage_schools.php" method="post">
            <h2>Fill this form to register new school.</h2>
            <input type="hidden" name="action" value="add">
            <input type="text" name="school_name" placeholder="School Name" required>
            <input type="text" name="district" placeholder="District" required>
            <input type="text" name="sector" placeholder="Sector" required>
            <input type="text" name="phone" placeholder="Phone" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Add School</button>
        </form>
        <hr>
        <form action="manage_schools.php" method="post">
        <h2>Search specific school.</h2>
            <input type="text" name="search_query" placeholder="Search schools..." value="<?php echo $search_query; ?>">
            <button type="submit" name="search">Search</button>
        </form>
        <hr>
        <table class="table-school">
        <h2>List of schools that are already registered.</h2>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>District</th>
                    <th>Sector</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result_schools->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['school_id']; ?></td>
                        <td><?php echo $row['School_name']; ?></td>
                        <td><?php echo $row['District']; ?></td>
                        <td><?php echo $row['Sector']; ?></td>
                        <td><?php echo $row['Phone']; ?></td>
                        <td><?php echo $row['Email']; ?></td>
                        <td><?php echo $row['Username']; ?></td>
                        <td><?php echo ($row['status'] == 1) ? 'Active' : 'Revoked'; ?></td>
                        <td>
                            <form class="f-action" action="manage_schools.php" method="post">
                                <button type="submit">Edit</button>
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="school_id" value="<?php echo $row['school_id']; ?>">
                                <button type="submit">Delete</button>

                                <?php if ($row['status'] == 1) { ?>
                                    <input type="hidden" name="action" value="revoke">
                                    <input type="hidden" name="school_id" value="<?php echo $row['school_id']; ?>">
                                    <button type="submit">Revoke</button>

                                <?php } else { ?>
                                    <input type="hidden" name="action" value="grant">
                                    <input type="hidden" name="school_id" value="<?php echo $row['school_id']; ?>">
                                    <button type="submit">Grant</button>
                                </form>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <footer class="footer">
        <p>&copy; niyonsenga felicien developer Keffa  </p>
    </footer>
</body>
</html>
