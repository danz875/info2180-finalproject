<?php
session_start();
require_once 'database.php';
require_once 'auth.php';

requireLogin();

$filter = $_GET['filter'] ?? 'all';
$userId = $_SESSION['user_id'];

$query = "SELECT c.*, CONCAT(c.title, ' ', c.firstname, ' ', c.lastname) as fullname
          FROM contacts c";

switch($filter) {
    case 'sales':
        $query .= " WHERE type = 'Sales Lead'";
        break;
    case 'support':
        $query .= " WHERE type = 'Support'";
        break;
    case 'assigned':
        $query .= " WHERE assigned_to = :userId";
        break;
}

$stmt = $conn->prepare($query);
if ($filter === 'assigned') {
    $stmt->bindParam(':userId', $userId);
}
$stmt->execute();
$contacts = $stmt->fetchAll();

if (empty($contacts)) {
    echo "<tr><td colspan='5' class='no-contacts'>No contacts found</td></tr>";
} else {
    foreach ($contacts as $contact) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($contact['fullname']) . "</td>";
        echo "<td>" . htmlspecialchars($contact['email']) . "</td>";
        echo "<td>" . htmlspecialchars($contact['company']) . "</td>";
        echo "<td>" . htmlspecialchars($contact['type']) . "</td>";
        echo "<td><a href='#' data-page='view-contact' data-id='{$contact['id']}'>View</a></td>";
        echo "</tr>";
    }
}
?>