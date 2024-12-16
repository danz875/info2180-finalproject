<?php
session_start();
require_once '../includes/auth.php';
require_once '../includes/database.php';

// Ensure user is logged in and is an admin
requireLogin();
if ($_SESSION['user_role'] !== 'admin') {
    echo "Access denied";
    exit();
}

// Sanitize and collect form data
$firstname = filter_input(INPUT_POST, 'firstname');
$lastname  = filter_input(INPUT_POST, 'lastname');
$email     = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$role      = filter_input(INPUT_POST, 'role');
$password  = $_POST['password'];

// Validate form data
if (!$firstname || !$lastname || !$email || !$role || !$password) {
    echo "Please fill in all fields.";
    exit();
}

// Hash the password
$hashedPassword = hashPassword($password);

// Check if email already exists
$checkStmt = $conn->prepare("SELECT COUNT(*) FROM Users WHERE email = ?");
$checkStmt->execute([$email]);
$emailExists = $checkStmt->fetchColumn() > 0;

if ($emailExists) {
    echo "Error: Email address already exists";
    exit();
}

// Insert new user into the database
$stmt = $conn->prepare("INSERT INTO Users (firstname, lastname, email, password, role) VALUES (?, ?, ?, ?, ?)");
$result = $stmt->execute([$firstname, $lastname, $email, $hashedPassword, $role]);

if ($result) {
    echo "User added successfully";
} else {
    echo "Error adding user";
}