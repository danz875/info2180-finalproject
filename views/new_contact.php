<?php
session_start();
require_once '../includes/auth.php';
require_once '../includes/database.php';

// Ensure user is logged in
requireLogin();

// Fetch all users for the Assigned To dropdown
$stmt = $conn->prepare("SELECT id, firstname, lastname FROM Users");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../assets/css/add_user.css">
</head>
<body>

<div class="dashboard-header">
    <h2>Create New Contact</h2>
    <!-- <button onclick="window.history.back()" class="btn-primary">Back to Dashboard</button> -->
</div>

<div class="add-user-container">
    <form id="new-contact-form">
        <div class="form-group">
            <label>Title:</label>
            <input type="text" name="title">
        </div>
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
            <label>Telephone:</label>
            <input type="tel" name="telephone">
        </div>
        <div class="form-group">
            <label>Company:</label>
            <input type="text" name="company">
        </div>
        <div class="form-group">
            <label>Type:</label>
            <select name="type" required>
                <option value="Sales Lead">Sales Lead</option>
                <option value="Support">Support</option>
            </select>
        </div>
        <div class="form-group">
            <label>Assigned To:</label>
            <select name="assigned_to" required>
                <?php foreach ($users as $user): ?>
                    <option value="<?php echo htmlspecialchars($user['id']); ?>">
                        <?php echo htmlspecialchars($user['firstname'] . ' ' . $user['lastname']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn-primary">Create Contact</button>
    </form>
</div>

<script>
    document.getElementById('new-contact-form').addEventListener('submit', function(event) {
        event.preventDefault();

        fetch('handlers/add_contact.php', {
            method: 'POST',
            body: new FormData(this)
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            window.location.href = 'dashboard.php';
        })
        .catch(error => {
            alert('Error adding contact');
        });
    });
</script>

</body>
</html>