<?php
require_once("db.php");

$id = $_GET['id'];

$sql = "DELETE FROM stu WHERE stuid=$id";
if (mysqli_query($con, $sql)) {
    header("Location: show.php");
    exit();
} else {
    echo "Error: " . mysqli_error($con);
}
?>