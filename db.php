<?php
/*
Run this SQL in phpMyAdmin first:

CREATE DATABASE IF NOT EXISTS student_db CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE student_db;

CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    major VARCHAR(100) NOT NULL,
    phone VARCHAR(30),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO students (name, email, major, phone) VALUES
('Ahmed Ali', 'ahmed@example.com', 'Computer Science', '0599000001'),
('Sara Omar', 'sara@example.com', 'Information Technology', '0599000002'),
('Khaled Sami', 'khaled@example.com', 'Software Engineering', '0599000003'),
('Mona Naser', 'mona@example.com', 'Computer Science', '0599000004'),
('Yousef Hasan', 'yousef@example.com', 'Information Systems', '0599000005'),
('Lina Adel', 'lina@example.com', 'Cyber Security', '0599000006'),
('Rami Saleh', 'rami@example.com', 'Data Science', '0599000007'),
('Huda Jamal', 'huda@example.com', 'Computer Science', '0599000008'),
('Omar Ziad', 'omar@example.com', 'Software Engineering', '0599000009'),
('Noor Sami', 'noor@example.com', 'Information Technology', '0599000010'),
('Anas Taha', 'anas@example.com', 'Cyber Security', '0599000011'),
('Reem Fadi', 'reem@example.com', 'Data Science', '0599000012');
*/

session_start();

$host = 'localhost';
$dbname = 'student_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}

function set_flash($type, $message) {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function show_flash() {
    if (!empty($_SESSION['flash'])) {
        $type = $_SESSION['flash']['type'];
        $message = $_SESSION['flash']['message'];
        echo "<div class='alert $type'>" . htmlspecialchars($message) . "</div>";
        unset($_SESSION['flash']);
    }
}

function clean($value) {
    return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
}
?>
