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

// Fetch all users
$stmt = $conn->prepare("SELECT id, firstname, lastname, email, role, created_at FROM Users");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="dashboard-header">
    <h2>Users</h2>
    <a href="#" class="btn-primary" id="add-user-btn">Add User</a>
</div>

<div class="users-table-container">
    <table class="users-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($users)): ?>
                <tr><td colspan="4" class="no-users">No users found</td></tr>
            <?php else: ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['firstname'] . ' ' . $user['lastname']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars($user['role']); ?></td>
                        <td><?php echo htmlspecialchars($user['created_at']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>