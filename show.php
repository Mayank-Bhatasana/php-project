<?php
require_once("db.php");
$result = mysqli_query($con, "SELECT * FROM stu");
?>
<!DOCTYPE html>
<html>
<head>
    <title>All Students</title>
    <link rel="stylesheet" href="style.css">

    <style>
        body{
          display: flex;  
          flex-direction: column;
        }
    </style>
</head>
<body>
    <h1>All Students info</h1>
    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Roll No</th>
            <th>Name</th>
            <th>Password</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['stuid']; ?></td>
            <td><?php echo $row['rollno']; ?></td>
            <td><?php echo $row['stuname']; ?></td>
            <td><?php echo $row['stupass']; ?></td>
            <td>
                <a href="update.php?id=<?php echo $row['stuid']; ?>">Update</a> |
                <a href="delete.php?id=<?php echo $row['stuid']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php } ?>
        <tr>
            <td colspan="5" style="text-align: center;">
                <a href="insert.php">Insert New Student</a>
            </td>
        </tr>
    </table>
</body>
</html>
