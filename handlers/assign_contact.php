<?php
session_start();
require_once '../includes/auth.php';
require_once '../includes/database.php';

// Ensure user is logged in
requireLogin();

$contactId = filter_input(INPUT_POST, 'contact_id', FILTER_SANITIZE_NUMBER_INT);

if (!$contactId) {
    echo "Invalid contact ID";
    exit();
}

$stmt = $conn->prepare("UPDATE Contacts SET assigned_to = ?, updated_at = NOW() WHERE id = ?");
$result = $stmt->execute([$_SESSION['user_id'], $contactId]);

if ($result) {
    echo "Contact assigned to you successfully";
} else {
    echo "Error assigning contact";
}
?>