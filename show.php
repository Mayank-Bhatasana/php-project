<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management - Show All Students</title>
    <link rel="stylesheet" href="show-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-graduation-cap"></i> Student Management System</h1>
            <nav class="navigation">
                <a href="index.html" class="nav-btn"><i class="fas fa-home"></i> Home</a>
                <a href="show.php" class="nav-btn active"><i class="fas fa-users"></i> All Students</a>
            </nav>
        </div>

        <div class="content">
            <div class="page-header">
                <h2><i class="fas fa-list"></i> All Students</h2>
                <p>Manage your student database with ease</p>
            </div>

            <div class="table-container">
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "student";

                // Create connection
                $con = mysqli_connect($servername, $username, $password, $dbname);

                // Check connection
                if (!$con) {
                    echo '<div class="error-message">
                            <i class="fas fa-exclamation-triangle"></i>
                            Connection failed: ' . mysqli_connect_error() . '
                          </div>';
                } else {
                    // Fetch all students
                    $query = "SELECT stuid, rollno, stuname, stupass FROM stu ORDER BY rollno";
                    $result = mysqli_query($con, $query);

                    if (mysqli_num_rows($result) > 0) {
                        echo '<table class="students-table">
                                <thead>
                                    <tr>
                                        <th><i class="fas fa-hashtag"></i> Roll No</th>
                                        <th><i class="fas fa-user"></i> Student Name</th>
                                        <th><i class="fas fa-key"></i> Password</th>
                                        <th><i class="fas fa-cogs"></i> Actions</th>
                                    </tr>
                                </thead>
                                <tbody>';

                        while($row = mysqli_fetch_assoc($result)) {
                            echo '<tr>
                                    <td data-label="Roll No">' . htmlspecialchars($row["rollno"]) . '</td>
                                    <td data-label="Student Name">' . htmlspecialchars($row["stuname"]) . '</td>
                                    <td data-label="Password">
                                        <span class="password-field">
                                            <span class="password-hidden">••••••••</span>
                                            <span class="password-visible" style="display: none;">' . htmlspecialchars($row["stupass"]) . '</span>
                                            <button class="toggle-password" onclick="togglePassword(this)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </span>
                                    </td>
                                    <td data-label="Actions" class="actions">
                                        <a href="update.php?id=' . $row["stuid"] . '" class="action-btn update-btn">
                                            <i class="fas fa-edit"></i> Update
                                        </a>
                                        <a href="delete.php?id=' . $row["stuid"] . '" class="action-btn delete-btn" 
                                           onclick="return confirm(\'Are you sure you want to delete this student?\')">
                                            <i class="fas fa-trash"></i> Delete
                                        </a>
                                    </td>
                                  </tr>';
                        }
                        echo '</tbody></table>';
                    } else {
                        echo '<div class="no-data">
                                <i class="fas fa-users-slash"></i>
                                <h3>No Students Found</h3>
                                <p>No students are currently registered in the system.</p>
                                <a href="index.html" class="register-btn">
                                    <i class="fas fa-user-plus"></i> Register New Student
                                </a>
                              </div>';
                    }

                    mysqli_close($con);
                }
                ?>
            </div>
        </div>

        <footer>
            <p><i class="fas fa-heart" style="color: #FF416C;"></i> Student Management System - Beautiful & Functional</p>
        </footer>
    </div>

    <script>
        function togglePassword(button) {
            const passwordField = button.parentElement;
            const hiddenSpan = passwordField.querySelector('.password-hidden');
            const visibleSpan = passwordField.querySelector('.password-visible');
            const icon = button.querySelector('i');

            if (hiddenSpan.style.display === 'none') {
                hiddenSpan.style.display = 'inline';
                visibleSpan.style.display = 'none';
                icon.className = 'fas fa-eye';
            } else {
                hiddenSpan.style.display = 'none';
                visibleSpan.style.display = 'inline';
                icon.className = 'fas fa-eye-slash';
            }
        }

        // Add smooth scrolling and animations
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach((row, index) => {
                row.style.animationDelay = `${index * 0.1}s`;
                row.classList.add('fade-in');
            });
        });
    </script>
</body>
</html>