<?php
session_start();
require_once '../includes/auth.php';
require_once '../includes/database.php';

// Ensure user is logged in
requireLogin();

// Sanitize and collect form data
$title      = filter_input(INPUT_POST, 'title');
$firstname  = filter_input(INPUT_POST, 'firstname');
$lastname   = filter_input(INPUT_POST, 'lastname');
$email      = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$telephone  = filter_input(INPUT_POST, 'telephone');
$company    = filter_input(INPUT_POST, 'company');
$type       = filter_input(INPUT_POST, 'type');
$assignedTo = filter_input(INPUT_POST, 'assigned_to', FILTER_SANITIZE_NUMBER_INT);

// Validate form data
if (!$firstname || !$lastname || !$email || !$type || !$assignedTo) {
    echo "Please fill in all required fields.";
    exit();
}

// Check if email already exists
$checkStmt = $conn->prepare("SELECT COUNT(*) FROM Contacts WHERE email = ?");
$checkStmt->execute([$email]);
$emailExists = $checkStmt->fetchColumn() > 0;

if ($emailExists) {
    echo "Error: Email address already exists";
    exit();
}

// Insert new contact into the database
$stmt = $conn->prepare("
    INSERT INTO Contacts (title, firstname, lastname, email, telephone, company, type, assigned_to, created_by)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
");
$result = $stmt->execute([
    $title,
    $firstname,
    $lastname,
    $email,
    $telephone,
    $company,
    $type,
    $assignedTo,
    $_SESSION['user_id']
]);

if ($result) {
    echo "Contact added successfully";
} else {
    echo "Error adding contact";
}
?>