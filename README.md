# Student Management System 🎓

A beautiful and functional PHP-based student management system with modern UI design and comprehensive CRUD operations.

## ✨ Features

- **Beautiful UI Design**: Modern gradient backgrounds, smooth animations, and responsive layout
- **Student Registration**: Register new students with name, roll number, and password
- **View All Students**: Display all students in a beautiful table format (excluding primary key for security)
- **Update Student Info**: Edit student name, roll number, and password with pre-filled forms
- **Delete Students**: Secure deletion with confirmation dialogs and warnings
- **Password Visibility Toggle**: Show/hide passwords in both view and update forms
- **Responsive Design**: Works perfectly on desktop, tablet, and mobile devices
- **Smooth Animations**: Fade-in effects, hover animations, and loading states

## 🚀 Installation & Setup

### Prerequisites
- PHP 7.0 or higher
- MySQL/MariaDB database server
- Web server (Apache/Nginx) or PHP built-in server

### Database Setup
1. Create a MySQL database named `student`
2. Run the SQL script provided in `database_setup.sql`
3. Or manually create the table structure:

```sql
CREATE DATABASE student;
USE student;

CREATE TABLE stu (
    stuid INT AUTO_INCREMENT PRIMARY KEY,
    rollno INT NOT NULL UNIQUE,
    stuname VARCHAR(100) NOT NULL,
    stupass VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### Running the Application
1. Clone or download this repository
2. Place files in your web server directory
3. Update database configuration in PHP files if needed:
   - Server: `localhost`
   - Username: `root`
   - Password: (empty)
   - Database: `student`

4. Start your web server or use PHP built-in server:
```bash
php -S localhost:8000
```

5. Open your browser and navigate to `http://localhost:8000`

## 📁 File Structure

```
php-project/
├── index.html              # Homepage with registration/login forms
├── show.php                # Display all students with action buttons
├── update.php              # Update student information
├── delete.php              # Delete student with confirmation
├── insert.php              # Handle student registration
├── style.css               # Main stylesheet for homepage
├── show-style.css          # Stylesheet for students listing page
├── update-style.css        # Stylesheet for update page
├── delete-style.css        # Stylesheet for delete page
├── script.js               # JavaScript for homepage interactions
├── database_setup.sql      # Database setup script
└── README.md               # This file
```

## 🎨 Design Features

### Color Scheme
- Primary gradient: Purple to blue (`#667eea` to `#764ba2`)
- Success colors: Green tones for positive actions
- Warning colors: Orange tones for cautions
- Error colors: Red tones for dangerous actions

### Typography
- Font family: Poppins (Google Fonts)
- Various font weights for hierarchy
- Responsive font sizes

### Interactive Elements
- Hover effects on all clickable elements
- Smooth transitions and animations
- Loading states for form submissions
- Confirmation dialogs for destructive actions

## 🔧 Customization

### Database Configuration
Update the database connection details in all PHP files:
```php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student";
```

### Styling
- Modify CSS files to change colors, fonts, and layouts
- All styles use CSS custom properties for easy theming
- Responsive breakpoints: 768px and 480px

## 📱 Responsive Design

The application is fully responsive and works on:
- Desktop computers (1200px+)
- Tablets (768px - 1199px)
- Mobile phones (320px - 767px)

## 🔒 Security Features

- SQL injection prevention using `mysqli_real_escape_string()`
- Password visibility toggle for secure viewing
- Confirmation dialogs for destructive actions
- Input validation and sanitization
- HTML entity encoding for XSS prevention

## 🚀 Usage

1. **Register Students**: Use the homepage form to add new students
2. **View Students**: Click "View All Students" to see the complete list
3. **Update Information**: Click the "Update" button next to any student
4. **Delete Students**: Click the "Delete" button with confirmation

## 🎯 Future Enhancements

- Password hashing for better security
- User authentication system
- Advanced search and filtering
- Export data to CSV/PDF
- Student photo uploads
- Course management
- Grade tracking

## 🤝 Contributing

Feel free to fork this project and submit pull requests for improvements!

## 📄 License

This project is open source and available under the MIT License.