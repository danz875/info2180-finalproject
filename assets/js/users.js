$(document).ready(function() {
    // Toggle to add user view
    $('#add-user-btn').click(function(e) {
        e.preventDefault();
        loadContent('add-user');
    });

    // Handle form submission
    $('#new-user-form').submit(function(e) {
        e.preventDefault();

        $.ajax({
            url: 'handlers/add_user.php',
            type: 'POST',
            data: $('#new-user-form').serialize(),
            success: function(response) {
                alert(response);
                // Reload the users page to reflect new user
                loadContent('users');
            },
            error: function() {
                alert('Error adding user');
            }
        });
    });
});