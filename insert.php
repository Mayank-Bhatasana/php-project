<?php
    if(isset($_POST["submit"])){
        require_once("db.php");
        if($con){
            $name = $_POST['stuname'];
            $rollno = $_POST['rollno'];
            $pass = $_POST['stupass'];

            $query = "INSERT INTO stu (stuname, rollno, stupass) VALUES ('$name', $rollno, '$pass')";

            $result = mysqli_query($con, $query);
            if($result){
                echo "<script>
                    alert('New student inserted successfully'); 
                    window.location.href='show.php';
                </script>";
            } else{
                echo "<script>
                    alert('Error inserting new student');
                </script>";
            }
        } else {
            die("Connection failed: " . mysqli_connect_error());
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Student Login</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
               <div class="brand">
                <div class="logo">🎓</div>
                <h1>Insert new Student</h1>
            </div>

            <form method="post" action="" class="login-form" novalidate>
                <label for="stuname">Name</label>
                <input id="stuname" name="stuname" type="text" placeholder="Student's name" required>

                <label for="rollno">Roll No</label>
                <input id="rollno" name="rollno" type="text" inputmode="numeric" pattern="\d*" placeholder="e.g. 101" required>

                <label for="stupass">Password</label>
                <div class="password-row">
                    <input id="stupass" name="stupass" type="password" placeholder="Student's password" required>
                    <button type="button" id="togglePass" class="toggle-pass" aria-label="Show password">Show</button>
                </div>

                <button class="btn primary" type="submit" name="submit">Insert</button>
            </form>

            <div class="card-footer">
                <p>Have account? then,</p>
                <a href="index.php">Login</a>
            </div>
        </div>
    </div>

<script>
document.getElementById('togglePass').addEventListener('click', function() {
    const p = document.getElementById('stupass');
    if (p.type === 'password') { p.type = 'text'; this.textContent = 'Hide'; }
    else { p.type = 'password'; this.textContent = 'Show'; }
});
</script>
</body>
</html>
