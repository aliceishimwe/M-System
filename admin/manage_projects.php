<?php
session_start();
include('../includes/db.php');

if (!isset($_SESSION['admin'])) {
    header('Location: ../index.php');
    exit();
}

// Handle set status
if (isset($_POST['action']) && $_POST['action'] == 'set_status') {
    $project_id = $_POST['project_id'];
    $status = $_POST['status'];
    $sql = "UPDATE Projects SET status='$status' WHERE project_id='$project_id'";
    $conn->query($sql);
}

// Fetch list of projects
$sql_projects = "SELECT Projects.*, Schools.School_name FROM Projects JOIN Schools ON Projects.school_id=Schools.school_id";
$result_projects = $conn->query($sql_projects);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Projects</title>
    <link rel="stylesheet" href="../css/style.css">

    <script>
        function printProjects() {
            var printContents = document.getElementById('projectsTable').outerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = "<html><head><title>Projects List</title></head><body>" + printContents + "</body>";
            window.print();
            document.body.innerHTML = originalContents;
        }

        function showEditForm(projectId) {
            document.getElementById('editForm-' + projectId).style.display = 'block';
        }
    </script>

</head>
<body>
    <div class="container">
        <h1>Manage Projects</h1>
        <nav>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="manage_schools.php">Manage Schools</a></li>
                <li><a href="manage_projects.php">Manage Projects</a></li>
                <li><a href="settings.php">Settings</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </nav>
        <button onclick="printProjects()">Print Projects List</button>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Project Name</th>
                    <th>Owner</th>
                    <th>School</th>
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
                        <td><?php echo $row['School_name']; ?></td>
                        <td><a href="../uploads/<?php echo $row['Project_file']; ?>" download>Download</a></td>
                        <td><?php echo $row['status']; ?></td>
                        <td>
                            <form action="manage_projects.php" method="post" style="display:inline-block;">
                                <input type="hidden" name="action" value="set_status">
                                <input type="hidden" name="project_id" value="<?php echo $row['project_id']; ?>">
                                <select name="status">
                                    <option value="Selected" <?php if ($row['status'] == 'Selected') echo 'selected'; ?>>Selected</option>
                                    <option value="Rejected" <?php if ($row['status'] == 'Rejected') echo 'selected'; ?>>Rejected</option>
                                </select>
                                <button type="submit">Set Status</button>
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
