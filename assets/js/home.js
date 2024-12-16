$(document).ready(function() {
    loadContacts('all');
    attachHomeEventHandlers();

    function loadContacts(filter) {
        $.ajax({
            url: 'includes/get-contacts.php',
            type: 'GET',
            data: { filter: filter },
            success: function(response) {
                $('#contacts-list').html(response);
            },
            error: function() {
                alert('Error loading contacts');
            }
        });
    }

    function attachHomeEventHandlers() {
        $('#dashboard-content').on('click', '.filter-btn', function() {
            $('.filter-btn').removeClass('active');
            $(this).addClass('active');
            loadContacts($(this).data('filter'));
        });
    }
});
