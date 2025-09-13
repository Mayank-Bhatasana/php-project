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

// Handle deletion confirmation
if (isset($_POST['confirm_delete'])) {
    $student_id = intval($_POST['student_id']);
    
    // Delete student
    $delete_query = "DELETE FROM stu WHERE stuid = $student_id";
    
    if (mysqli_query($con, $delete_query)) {
        $success_message = "Student has been successfully deleted from the database!";
        $student = null; // Clear student data as it's been deleted
    } else {
        $error_message = "Error deleting student: " . mysqli_error($con);
    }
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management - Delete Student</title>
    <link rel="stylesheet" href="delete-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-graduation-cap"></i> Student Management System</h1>
            <nav class="navigation">
                <a href="index.html" class="nav-btn"><i class="fas fa-home"></i> Home</a>
                <a href="show.php" class="nav-btn"><i class="fas fa-users"></i> All Students</a>
                <a href="delete.php" class="nav-btn active"><i class="fas fa-trash"></i> Delete</a>
            </nav>
        </div>

        <div class="content">
            <div class="page-header">
                <h2><i class="fas fa-user-times"></i> Delete Student</h2>
                <p>Remove student record from the database permanently</p>
            </div>

            <?php if ($error_message): ?>
                <div class="message error-message">
                    <i class="fas fa-exclamation-triangle"></i>
                    <?php echo $error_message; ?>
                </div>
                <div class="actions-container">
                    <a href="show.php" class="back-btn">
                        <i class="fas fa-arrow-left"></i> Back to Students List
                    </a>
                </div>
            <?php elseif ($success_message): ?>
                <div class="message success-message">
                    <i class="fas fa-check-circle"></i>
                    <?php echo $success_message; ?>
                </div>
                <div class="success-actions">
                    <div class="success-icon">
                        <i class="fas fa-trash-alt"></i>
                    </div>
                    <h3>Student Successfully Deleted</h3>
                    <p>The student record has been permanently removed from the database.</p>
                    <div class="actions-container">
                        <a href="show.php" class="back-btn">
                            <i class="fas fa-users"></i> View All Students
                        </a>
                        <a href="index.html" class="home-btn">
                            <i class="fas fa-home"></i> Go Home
                        </a>
                    </div>
                </div>
            <?php elseif ($student): ?>
                <div class="warning-box">
                    <div class="warning-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <h3>Warning: Permanent Action</h3>
                    <p>You are about to permanently delete this student from the database. This action cannot be undone.</p>
                </div>

                <div class="student-details">
                    <h3><i class="fas fa-user"></i> Student Information</h3>
                    <div class="details-grid">
                        <div class="detail-item">
                            <label>Student ID:</label>
                            <span><?php echo $student['stuid']; ?></span>
                        </div>
                        <div class="detail-item">
                            <label>Student Name:</label>
                            <span><?php echo htmlspecialchars($student['stuname']); ?></span>
                        </div>
                        <div class="detail-item">
                            <label>Roll Number:</label>
                            <span><?php echo $student['rollno']; ?></span>
                        </div>
                        <div class="detail-item">
                            <label>Password:</label>
                            <span class="password-display">••••••••</span>
                        </div>
                    </div>
                </div>

                <div class="confirmation-section">
                    <h3><i class="fas fa-question-circle"></i> Are you absolutely sure?</h3>
                    <p>Please confirm that you want to delete <strong><?php echo htmlspecialchars($student['stuname']); ?></strong> (Roll: <?php echo $student['rollno']; ?>) from the database.</p>
                    
                    <form method="POST" action="" id="deleteForm">
                        <input type="hidden" name="student_id" value="<?php echo $student['stuid']; ?>">
                        
                        <div class="checkbox-container">
                            <input type="checkbox" id="confirmCheck" required>
                            <label for="confirmCheck">I understand that this action is permanent and cannot be undone</label>
                        </div>

                        <div class="actions-container">
                            <button type="submit" name="confirm_delete" class="delete-btn" id="deleteButton" disabled>
                                <i class="fas fa-trash"></i> Yes, Delete Student
                            </button>
                            <a href="show.php" class="cancel-btn">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            <?php else: ?>
                <div class="no-student">
                    <i class="fas fa-user-slash"></i>
                    <h3>No Student Selected</h3>
                    <p>Please select a student from the students list to delete.</p>
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
        document.addEventListener('DOMContentLoaded', function() {
            const confirmCheck = document.getElementById('confirmCheck');
            const deleteButton = document.getElementById('deleteButton');
            const deleteForm = document.getElementById('deleteForm');

            // Enable/disable delete button based on checkbox
            if (confirmCheck && deleteButton) {
                confirmCheck.addEventListener('change', function() {
                    deleteButton.disabled = !this.checked;
                    
                    if (this.checked) {
                        deleteButton.classList.add('enabled');
                    } else {
                        deleteButton.classList.remove('enabled');
                    }
                });
            }

            // Add confirmation dialog and animation
            if (deleteForm) {
                deleteForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const studentName = '<?php echo isset($student) ? addslashes($student['stuname']) : ''; ?>';
                    const rollNo = '<?php echo isset($student) ? $student['rollno'] : ''; ?>';
                    
                    if (confirm(`Are you absolutely sure you want to delete ${studentName} (Roll: ${rollNo})?\n\nThis action cannot be undone!`)) {
                        // Show loading state
                        deleteButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Deleting...';
                        deleteButton.disabled = true;
                        
                        // Submit form after a short delay for better UX
                        setTimeout(() => {
                            this.submit();
                        }, 500);
                    }
                });
            }

            // Auto-redirect after successful deletion
            const successMessage = document.querySelector('.success-message');
            if (successMessage) {
                // Auto-redirect to students list after 5 seconds
                let countdown = 5;
                const countdownElement = document.createElement('div');
                countdownElement.className = 'countdown';
                countdownElement.innerHTML = `<p>Redirecting to students list in <span id="countdown">${countdown}</span> seconds...</p>`;
                successMessage.parentElement.appendChild(countdownElement);

                const countdownTimer = setInterval(() => {
                    countdown--;
                    document.getElementById('countdown').textContent = countdown;
                    
                    if (countdown <= 0) {
                        clearInterval(countdownTimer);
                        window.location.href = 'show.php';
                    }
                }, 1000);
            }
        });

        // Add smooth animations
        function animateElements() {
            const elements = document.querySelectorAll('.student-details, .confirmation-section, .warning-box');
            elements.forEach((element, index) => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    element.style.transition = 'all 0.5s ease';
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }, index * 200);
            });
        }

        // Run animations when page loads
        if (document.querySelector('.student-details')) {
            animateElements();
        }
    </script>
</body>
</html>