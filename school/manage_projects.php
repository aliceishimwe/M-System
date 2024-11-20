<?php
session_start();
include('../includes/db.php');

if (!isset($_SESSION['school'])) {
    header('Location: ../index.php');
    exit();
}

// Get the school ID
$school_username = $_SESSION['school'];
$sql_school_id = "SELECT school_id FROM Schools WHERE Username='$school_username'";
$result_school_id = $conn->query($sql_school_id);
$school_id = $result_school_id->fetch_assoc()['school_id'];

// Handle add, edit project operations
if (isset($_POST['action'])) {
    $action = $_POST['action'];
    
    if ($action == 'add') {
        $project_name = $_POST['project_name'];
        $project_owner = $_POST['project_owner'];
        $project_file = $_FILES['project_file']['name'];
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES['project_file']['name']);
        move_uploaded_file($_FILES['project_file']['tmp_name'], $target_file);

        $sql = "INSERT INTO Projects (Project_name, Project_owner, Project_file, school_id)
                VALUES ('$project_name', '$project_owner', '$project_file', '$school_id')";
        $conn->query($sql);
    } elseif ($action == 'edit') {
        $project_id = $_POST['project_id'];
        $project_name = $_POST['project_name'];
        $project_owner = $_POST['project_owner'];
        $project_file = $_FILES['project_file']['name'];
        if ($project_file) {
            $target_dir = "../uploads/";
            $target_file = $target_dir . basename($_FILES['project_file']['name']);
            move_uploaded_file($_FILES['project_file']['tmp_name'], $target_file);
            $sql = "UPDATE Projects SET Project_name='$project_name', Project_owner='$project_owner', Project_file='$project_file' WHERE project_id='$project_id'";
        } else {
            $sql = "UPDATE Projects SET Project_name='$project_name', Project_owner='$project_owner' WHERE project_id='$project_id'";
        }
        $conn->query($sql);
    }
}

// Fetch list of projects
$sql_projects = "SELECT * FROM Projects WHERE school_id='$school_id'";
$result_projects = $conn->query($sql_projects);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Projects</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Manage Projects</h1>
        <nav>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="manage_projects.php">Manage Projects</a></li>
                <li><a href="settings.php">Settings</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </nav>
        <form action="manage_projects.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action" value="add">
            <input type="text" name="project_name" placeholder="Project Name" required>
            <input type="text" name="project_owner" placeholder="Project Owner" required>
            <input type="file" name="project_file" required>
            <button type="submit">Add Project</button>
        </form>
        <hr>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Owner</th>
                    <th>File</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result_projects->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['project_id']; ?></td>
                        <td><?php echo $row['Project_name']; ?></td>
                        <td><?php echo $row['Project_owner']; ?></td>
                        <td><a href="../uploads/<?php echo $row['Project_file']; ?>" download>Download</a></td>
                        <td><?php echo $row['status']; ?></td>
                        <td>
                            <form action="manage_projects.php" method="post" enctype="multipart/form-data" style="display:inline-block;">
                                <input type="hidden" name="action" value="edit">
                                <input type="hidden" name="project_id" value="<?php echo $row['project_id']; ?>">
                                <input type="text" name="project_name" value="<?php echo $row['Project_name']; ?>" required>
                                <input type="text" name="project_owner" value="<?php echo $row['Project_owner']; ?>" required>
                                <input type="file" name="project_file">
                                <button type="submit">Edit</button>
                            </form>
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
