<?php
session_start();
require_once '../includes/auth.php';
require_once '../includes/database.php';

// Ensure user is logged in
requireLogin();

$contactId = filter_input(INPUT_POST, 'contact_id', FILTER_SANITIZE_NUMBER_INT);
$comment = filter_input(INPUT_POST, 'comment');

if (!$contactId || !$comment) {
    echo "Please fill in all required fields.";
    exit();
}

$stmt = $conn->prepare("INSERT INTO Notes (contact_id, comment, created_by) VALUES (?, ?, ?)");
$result = $stmt->execute([$contactId, $comment, $_SESSION['user_id']]);

if ($result) {
    echo "Note added successfully";
} else {
    echo "Error adding note";
}
?>