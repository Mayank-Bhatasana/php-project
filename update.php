<?php
require_once("db.php");

$id = $_GET['id'];
$sql = "SELECT * FROM stu WHERE stuid=$id";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

if (isset($_POST["update"])) {
    $rollno = $_POST['rollno'];
    $stuname = $_POST['stuname'];
    $stupass = $_POST['stupass'];

    $update = "UPDATE stu SET rollno='$rollno', stuname='$stuname', stupass='$stupass' WHERE stuid=$id";
    if (mysqli_query($con, $update)) {
        header("Location: show.php");
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update Student</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body{
          display: flex;  
          flex-direction: column;
        }
    </style>
</head>
<body>
    <h2>Update Student</h2>
    <form method="POST" action="">
        Roll No: <input type="text" name="rollno" value="<?php echo $row['rollno']; ?>" required><br><br>
        Name: <input type="text" name="stuname" value="<?php echo $row['stuname']; ?>" required><br><br>
        Password: <input type="password" name="stupass" value="<?php echo $row['stupass']; ?>" required><br><br>
        <input type="submit" value="Update" name="update">
    </form>
</body>
</html>
