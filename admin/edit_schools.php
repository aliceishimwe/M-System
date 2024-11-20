<form action="edit_schools.php" method="post">
    <input type="hidden" name="school_id" value="<?php echo $school['school_id']; ?>">
    <input type="text" name="school_name" value="<?php echo $school['school_name']; ?>" required>
    <input type="text" name="district" value="<?php echo $school['district']; ?>" required>
    <input type="text" name="sector" value="<?php echo $school['sector']; ?>" required>
    <input type="text" name="phone" value="<?php echo $school['phone']; ?>" required>
    <input type="email" name="email" value="<?php echo $school['email']; ?>" required>
    <input type="text" name="username" value="<?php echo $school['username']; ?>" required>
    <button type="submit" name="edit_school">Save Changes</button>
</form>

<?php
include('../includes/db.php');

if (isset($_POST['edit_school'])) {
    $school_id = $_POST['school_id'];
    $school_name = $_POST['school_name'];
    $district = $_POST['district'];
    $sector = $_POST['sector'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $username = $_POST['username'];

    $sql = "UPDATE Schools SET school_name='$school_name', district='$district', sector='$sector', phone='$phone', email='$email', username='$username' WHERE school_id='$school_id'";
    if ($conn->query($sql) === TRUE) {
        echo "School updated successfully";
    } else {
        echo "Error updating school: " . $conn->error;
    }
}

// Fetching the school information to display in the form
if (isset($_GET['school_id'])) {
    $school_id = $_GET['school_id'];
    $sql = "SELECT * FROM Schools WHERE school_id='$school_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $school = $result->fetch_assoc();
    } else {
        echo "No school found";
    }
}
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
        <h1>Edit School</h1>
        <form action="edit_schools.php" method="post">
            <input type="hidden" name="school_id" value="<?php echo $school['school_id']; ?>">
            <input type="text" name="school_name" value="<?php echo $school['school_name']; ?>" required>
            <input type="text" name="district" value="<?php echo $school['district']; ?>" required>
            <input type="text" name="sector" value="<?php echo $school['sector']; ?>" required>
            <input type="text" name="phone" value="<?php echo $school['phone']; ?>" required>
            <input type="email" name="email" value="<?php echo $school['email']; ?>" required>
            <input type="text" name="username" value="<?php echo $school['username']; ?>" required>
            <button type="submit" name="edit_school">Save Changes</button>
        </form>
    </div>
</body>
</html>
