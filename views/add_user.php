<?php
session_start();
require_once '../includes/auth.php';

// Ensure user is logged in and is an admin
requireLogin();
if ($_SESSION['user_role'] !== 'admin') {
    echo "Access denied";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../css/add_user.css">
</head>
<body>


<div class="dashboard-header">
    <h2>Add New User</h2>
    <button onclick="" class="btn-primary">Back to Users</button>
</div>

<div class="add-user-container">
    <form id="new-user-form">
        <div class="form-group">
            <label>First Name:</label>
            <input type="text" name="firstname" required>
        </div>
        <div class="form-group">
            <label>Last Name:</label>
            <input type="text" name="lastname" required>
        </div>
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" required>
        </div>
        <div class="form-group">
            <label>Role:</label>
            <select name="role" required>
                <option value="staff">Staff</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <div class="form-group">
            <label>Password:</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit" class="btn-primary">Create User</button>
    </form>
</div>

</body>
</html>
