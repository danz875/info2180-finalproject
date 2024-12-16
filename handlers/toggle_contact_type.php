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

$stmt = $conn->prepare("SELECT type FROM Contacts WHERE id = ?");
$stmt->execute([$contactId]);
$contact = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$contact) {
    echo "Contact not found";
    exit();
}

$newType = $contact['type'] === 'Sales Lead' ? 'Support' : 'Sales Lead';

$stmt = $conn->prepare("UPDATE Contacts SET type = ?, updated_at = NOW() WHERE id = ?");
$result = $stmt->execute([$newType, $contactId]);

if ($result) {
    echo "Contact type toggled successfully";
} else {
    echo "Error toggling contact type";
}
?>