<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student";

// Create connection
$con = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$student = null;
$error_message = "";
$success_message = "";

// Get student ID from URL
if (isset($_GET['id'])) {
    $student_id = intval($_GET['id']);
    
    // Fetch student data
    $query = "SELECT * FROM stu WHERE stuid = $student_id";
    $result = mysqli_query($con, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $student = mysqli_fetch_assoc($result);
    } else {
        $error_message = "Student not found!";
    }
}

// Handle form submission
if (isset($_POST['update'])) {
    $student_id = intval($_POST['student_id']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $roll = intval($_POST['roll']);
    $pass = mysqli_real_escape_string($con, $_POST['pass']);
    
    // Check if roll number is already taken by another student
    $check_query = "SELECT stuid FROM stu WHERE rollno = $roll AND stuid != $student_id";
    $check_result = mysqli_query($con, $check_query);
    
    if (mysqli_num_rows($check_result) > 0) {
        $error_message = "Roll number already exists for another student!";
    } else {
        // Update student data
        $update_query = "UPDATE stu SET rollno = $roll, stuname = '$name', stupass = '$pass' WHERE stuid = $student_id";
        
        if (mysqli_query($con, $update_query)) {
            $success_message = "Student information updated successfully!";
            
            // Refresh student data
            $query = "SELECT * FROM stu WHERE stuid = $student_id";
            $result = mysqli_query($con, $query);
            $student = mysqli_fetch_assoc($result);
        } else {
            $error_message = "Error updating student: " . mysqli_error($con);
        }
    }
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management - Update Student</title>
    <link rel="stylesheet" href="update-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-graduation-cap"></i> Student Management System</h1>
            <nav class="navigation">
                <a href="index.html" class="nav-btn"><i class="fas fa-home"></i> Home</a>
                <a href="show.php" class="nav-btn"><i class="fas fa-users"></i> All Students</a>
                <a href="update.php" class="nav-btn active"><i class="fas fa-edit"></i> Update</a>
            </nav>
        </div>

        <div class="content">
            <div class="page-header">
                <h2><i class="fas fa-user-edit"></i> Update Student Information</h2>
                <p>Modify student details with care and precision</p>
            </div>

            <?php if ($error_message): ?>
                <div class="message error-message">
                    <i class="fas fa-exclamation-triangle"></i>
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>

            <?php if ($success_message): ?>
                <div class="message success-message">
                    <i class="fas fa-check-circle"></i>
                    <?php echo $success_message; ?>
                </div>
            <?php endif; ?>

            <?php if ($student): ?>
                <div class="form-container">
                    <form method="POST" action="">
                        <input type="hidden" name="student_id" value="<?php echo $student['stuid']; ?>">
                        
                        <div class="form-group">
                            <label for="name"><i class="fas fa-user"></i> Student Name</label>
                            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($student['stuname']); ?>" required>
                            <span class="input-highlight"></span>
                        </div>

                        <div class="form-group">
                            <label for="roll"><i class="fas fa-hashtag"></i> Roll Number</label>
                            <input type="number" id="roll" name="roll" value="<?php echo $student['rollno']; ?>" required>
                            <span class="input-highlight"></span>
                        </div>

                        <div class="form-group">
                            <label for="pass"><i class="fas fa-key"></i> Password</label>
                            <div class="password-input">
                                <input type="password" id="pass" name="pass" value="<?php echo htmlspecialchars($student['stupass']); ?>" required>
                                <button type="button" class="toggle-password" onclick="togglePassword()">
                                    <i class="fas fa-eye" id="toggleIcon"></i>
                                </button>
                            </div>
                            <span class="input-highlight"></span>
                        </div>

                        <div class="form-actions">
                            <button type="submit" name="update" class="update-btn">
                                <i class="fas fa-save"></i> Update Student
                            </button>
                            <a href="show.php" class="cancel-btn">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>

                <div class="student-info">
                    <h3><i class="fas fa-info-circle"></i> Current Student Information</h3>
                    <div class="info-grid">
                        <div class="info-item">
                            <label>Student ID:</label>
                            <span><?php echo $student['stuid']; ?></span>
                        </div>
                        <div class="info-item">
                            <label>Current Name:</label>
                            <span><?php echo htmlspecialchars($student['stuname']); ?></span>
                        </div>
                        <div class="info-item">
                            <label>Current Roll:</label>
                            <span><?php echo $student['rollno']; ?></span>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="no-student">
                    <i class="fas fa-user-slash"></i>
                    <h3>Student Not Found</h3>
                    <p>The student you're looking for doesn't exist or has been removed.</p>
                    <a href="show.php" class="back-btn">
                        <i class="fas fa-arrow-left"></i> Back to Students List
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <footer>
            <p><i class="fas fa-heart" style="color: #FF416C;"></i> Student Management System - Beautiful & Functional</p>
        </footer>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('pass');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.className = 'fas fa-eye-slash';
            } else {
                passwordInput.type = 'password';
                toggleIcon.className = 'fas fa-eye';
            }
        }

        // Add form validation and animations
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const inputs = document.querySelectorAll('input[type="text"], input[type="number"], input[type="password"]');

            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('focused');
                });

                input.addEventListener('blur', function() {
                    if (this.value === '') {
                        this.parentElement.classList.remove('focused');
                    }
                });

                // Check if input has value on load
                if (input.value !== '') {
                    input.parentElement.classList.add('focused');
                }
            });

            // Form submission animation
            if (form) {
                form.addEventListener('submit', function(e) {
                    const submitBtn = document.querySelector('.update-btn');
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';
                    submitBtn.disabled = true;
                });
            }
        });

        // Auto-hide success message after 3 seconds
        const successMessage = document.querySelector('.success-message');
        if (successMessage) {
            setTimeout(() => {
                successMessage.style.opacity = '0';
                setTimeout(() => {
                    successMessage.style.display = 'none';
                }, 300);
            }, 3000);
        }
    </script>
</body>
</html>