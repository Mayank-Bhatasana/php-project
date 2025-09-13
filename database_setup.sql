-- Student Management System Database Setup
-- Run this SQL script to create the database and table structure

-- Create database
CREATE DATABASE IF NOT EXISTS student;
USE student;

-- Create students table
CREATE TABLE IF NOT EXISTS stu (
    stuid INT AUTO_INCREMENT PRIMARY KEY,
    rollno INT NOT NULL UNIQUE,
    stuname VARCHAR(100) NOT NULL,
    stupass VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert sample data for testing (optional)
INSERT INTO stu (rollno, stuname, stupass) VALUES
(101, 'John Doe', 'password123'),
(102, 'Jane Smith', 'mypassword'),
(103, 'Mike Johnson', 'securepass'),
(104, 'Sarah Wilson', 'password456'),
(105, 'David Brown', 'mypass123');

-- Display all students
SELECT * FROM stu;