<?php
session_start();
require_once '../includes/auth.php';
require_once '../includes/database.php';

// Ensure user is logged in
requireLogin();

// Get contact ID from URL parameter
$contactId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!$contactId) {
    echo "Invalid contact ID";
    exit();
}

// Fetch contact details
$stmt = $conn->prepare("SELECT * FROM Contacts WHERE id = ?");
$stmt->execute([$contactId]);
$contact = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$contact) {
    echo "Contact not found";
    exit();
}

// Fetch user details for assigned_to
$userStmt = $conn->prepare("SELECT firstname, lastname FROM Users WHERE id = ?");
$userStmt->execute([$contact['assigned_to']]);
$user = $userStmt->fetch(PDO::FETCH_ASSOC);

// Fetch notes for the contact
$notesStmt = $conn->prepare("SELECT n.comment, u.firstname, u.lastname, n.created_at 
                            FROM Notes n 
                            JOIN Users u ON n.created_by = u.id 
                            WHERE n.contact_id = ?");
$notesStmt->execute([$contactId]);
$notes = $notesStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../assets/css/styles.css">
</head>
<body>

<div class="dashboard-header">
    <h2>Contact Details</h2>
    <button onclick="window.history.back()" class="btn-primary">Back to Dashboard</button>
</div>

<div class="contact-details-container">
    <h3><?php echo htmlspecialchars($contact['title'] . ' ' . $contact['firstname'] . ' ' . $contact['lastname']); ?></h3>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($contact['email']); ?></p>
    <p><strong>Company:</strong> <?php echo htmlspecialchars($contact['company']); ?></p>
    <p><strong>Telephone:</strong> <?php echo htmlspecialchars($contact['telephone']); ?></p>
    <p><strong>Date Created:</strong> <?php echo htmlspecialchars($contact['created_at']); ?></p>
    <p><strong>Created By:</strong> 
        <?php 
        $createdByStmt = $conn->prepare("SELECT firstname, lastname FROM Users WHERE id = ?");
        $createdByStmt->execute([$contact['created_by']]);
        $createdByUser = $createdByStmt->fetch(PDO::FETCH_ASSOC);
        echo htmlspecialchars($createdByUser['firstname'] . ' ' . $createdByUser['lastname']);
        ?>
    </p>
    <p><strong>Date Last Updated:</strong> <?php echo htmlspecialchars($contact['updated_at']); ?></p>
    <p><strong>Assigned To:</strong> 
        <?php 
        if ($user) {
            echo htmlspecialchars($user['firstname'] . ' ' . $user['lastname']);
        } else {
            echo "Not Assigned";
        }
        ?>
    </p>
    <p><strong>Type:</strong> <?php echo htmlspecialchars($contact['type']); ?></p>

    <button onclick="assignToMe()">Assign to Me</button>
    <button onclick="toggleType()">Toggle Type</button>

    <h4>Notes</h4>
    <div class="notes-container">
        <?php if (empty($notes)): ?>
            <p>No notes found.</p>
        <?php else: ?>
            <?php foreach ($notes as $note): ?>
                <div class="note">
                    <p><strong><?php echo htmlspecialchars($note['firstname'] . ' ' . $note['lastname']); ?></strong> - <?php echo htmlspecialchars($note['created_at']); ?></p>
                    <p><?php echo htmlspecialchars($note['comment']); ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <h4>Add New Note</h4>
    <form id="add-note-form">
        <textarea name="comment" placeholder="Enter your note here..." required></textarea>
        <button type="submit" class="btn-primary">Add Note</button>
    </form>
</div>

<script>
    function assignToMe() {
        fetch('handlers/assign_contact.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'contact_id=<?php echo $contactId; ?>'
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            location.reload();
        })
        .catch(error => {
            alert('Error assigning contact');
        });
    }

    function toggleType() {
        fetch('handlers/toggle_contact_type.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'contact_id=<?php echo $contactId; ?>'
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            location.reload();
        })
        .catch(error => {
            alert('Error toggling contact type');
        });
    }

    document.getElementById('add-note-form').addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(this);
        formData.append('contact_id', <?php echo $contactId; ?>);

        fetch('handlers/add_note.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            location.reload();
        })
        .catch(error => {
            alert('Error adding note');
        });
    });
</script>

</body>
</html>