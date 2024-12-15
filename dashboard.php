<?php
session_start();
require_once 'includes/auth.php';
require_once 'includes/database.php';

// Ensure user is logged in
requireLogin();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dolphin CRM - Dashboard</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="dashboard-container">
        <nav class="sidebar">
            <div class="logo">Dolphin CRM</div>
            <div class="user-info">
                Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>
            </div>
            <ul class="nav-links">
                <li><a href="#" class="active" data-page="home">Home</a></li>
                <li><a href="#" data-page="new-contact">New Contact</a></li>
                <?php if ($_SESSION['user_role'] === 'admin'): ?>
                    <li><a href="#" data-page="users">Users</a></li>
                <?php endif; ?>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>

        <main class="content">
            <div id="dashboard-content">
                <div class="dashboard-header">
                    <h2>Dashboard</h2>
                    <a href="#" class="btn-primary" data-page="new-contact">Add Contact</a>
                </div>
                <div class="filter-container">
                    <button class="filter-btn active" data-filter="all">All Contacts</button>
                    <button class="filter-btn" data-filter="sales">Sales Leads</button>
                    <button class="filter-btn" data-filter="support">Support</button>
                    <button class="filter-btn" data-filter="assigned">Assigned to me</button>
                </div>
                <div class="contacts-table-container">
                    <table class="contacts-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Company</th>
                                <th>Type</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="contacts-list">
                            <!-- Contacts will be loaded here via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
    <script src="assets/js/dashboard.js"></script>
</body>
</html>