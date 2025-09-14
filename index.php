<?php
require_once 'db.php';

// If user already logged in, redirect
if (!empty($_SESSION['rollno'])) {
    header('Location: show.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rollno = isset($_POST['rollno']) ? trim($_POST['rollno']) : '';
    $password = isset($_POST['stupass']) ? trim($_POST['stupass']) : '';

    if ($rollno === '' || $password === '') {
        $error = 'Please enter both Roll No and Password.';
    } elseif (!ctype_digit($rollno)) {
        $error = 'Roll No must contain only digits.';
    } else {
        $stmt = mysqli_prepare($con, "SELECT stuid, rollno, stuname, stupass FROM stu WHERE rollno = ? LIMIT 1");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'i', $rollno);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result && mysqli_num_rows($result) === 1) {
                $row = mysqli_fetch_assoc($result);

                // NOTE: table currently stores plaintext passwords (stupass).
                // If you later switch to hashed passwords, use password_verify().
                if ($row['stupass'] === $password) {
                    session_regenerate_id(true);
                    $_SESSION['stuid'] = $row['stuid'];
                    $_SESSION['rollno'] = $row['rollno'];
                    $_SESSION['stuname'] = $row['stuname'];
                    header('Location: show.php');
                    exit;
                } else {
                    $error = 'Invalid Roll Number or Password.';
                }
            } else {
                $error = 'Invalid Roll Number or Password.';
            }

            mysqli_stmt_close($stmt);
        } else {
            $error = 'Database error: ' . mysqli_error($con);
        }
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
                <h1>Student Portal</h1>
                <p class="subtitle">Sign in with your Roll Number</p>
            </div>

            <form method="post" action="" class="login-form" novalidate>
                <label for="rollno">Roll No</label>
                <input id="rollno" name="rollno" type="text" inputmode="numeric" pattern="\d*" placeholder="e.g. 101" required>

                <label for="stupass">Password</label>
                <div class="password-row">
                    <input id="stupass" name="stupass" type="password" placeholder="Your password" required>
                    <button type="button" id="togglePass" class="toggle-pass" aria-label="Show password">Show</button>
                </div>

                <button class="btn primary" type="submit">Login</button>
            </form>
            <p class="subtitle">Student not in the database? <a href="insert.php">Register here</a></p>
        </div>
    </div>
</body>
</html>
