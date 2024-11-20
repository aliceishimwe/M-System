<?php
session_start();
include('../includes/db.php');

if (!isset($_SESSION['school'])) {
    header('Location: ../index.php');
    exit();
}

$username = $_SESSION['school'];

// Fetch school details from the database
$sql_school = "SELECT * FROM Schools WHERE Username='$username'";
$result_school = $conn->query($sql_school);

if ($result_school->num_rows > 0) {
    $school = $result_school->fetch_assoc();
} else {
    echo "No school found";
    exit();
}

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    
    if ($action == 'change_profile') {
        $email = $_POST['email'];
        $sql = "UPDATE Schools SET Email='$email' WHERE Username='$username'";
        if ($conn->query($sql) === TRUE) {
            echo "Profile updated successfully";
        } else {
            echo "Error updating profile: " . $conn->error;
        }
    } elseif ($action == 'change_username') {
        $new_username = $_POST['new_username'];
        $sql = "UPDATE Schools SET Username='$new_username' WHERE Username='$username'";
        if ($conn->query($sql) === TRUE) {
            $_SESSION['school'] = $new_username;
            echo "Username updated successfully";
        } else {
            echo "Error updating username: " . $conn->error;
        }
    } elseif ($action == 'change_password') {
        $new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);
        $sql = "UPDATE Schools SET Password='$new_password' WHERE Username='$username'";
        if ($conn->query($sql) === TRUE) {
            echo "Password updated successfully";
        } else {
            echo "Error updating password: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>School Settings</title>
    <link rel="stylesheet" href="../css/style.css">
    <script>
        function showChangeForm(formId) {
            document.getElementById('changeProfileForm').style.display = 'none';
            document.getElementById('changeUsernameForm').style.display = 'none';
            document.getElementById('changePasswordForm').style.display = 'none';
            document.getElementById(formId).style.display = 'block';
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>School Settings</h1>
        <nav>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="manage_projects.php">Manage Projects</a></li>
                <li><a href="settings.php">Settings</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </nav>
        <button class="change" onclick="showChangeForm('changeProfileForm')">Change Profile</button>
        <button class="change" onclick="showChangeForm('changeUsernameForm')">Change Username</button>
        <button  class="change"onclick="showChangeForm('changePasswordForm')">Change Password</button>

        <form id="changeProfileForm" action="settings.php" method="post" style="display:none;">
            <input type="hidden" name="action" value="change_profile">
            <input type="email" name="email" value="<?php echo $school['Email']; ?>" required>
            <button type="submit">Change Profile</button>
        </form>
        
        <form id="changeUsernameForm" action="settings.php" method="post" style="display:none;">
            <input type="hidden" name="action" value="change_username">
            <input type="text" name="new_username" placeholder="New Username" required>
            <button type="submit">Change Username</button>
        </form>
        
        <form id="changePasswordForm" action="settings.php" method="post" style="display:none;">
            <input type="hidden" name="action" value="change_password">
            <input type="password" name="new_password" placeholder="New Password" required>
            <button type="submit">Change Password</button>
        </form>
    </div>
</body>
</html>
