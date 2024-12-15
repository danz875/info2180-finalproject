// assets/js/dashboard.js
$(document).ready(function() {
    // Load default content (home)
    loadContent('home');

    // Load initial contacts
    loadContacts('all');

    // Handle navigation clicks
    $('.nav-links a').click(function(e) {
        e.preventDefault();
        $('.nav-links a').removeClass('active');
        $(this).addClass('active');
        
        const page = $(this).data('page');
        loadContent(page);
    });

    // Handle filter buttons
    $('.filter-btn').click(function() {
        $('.filter-btn').removeClass('active');
        $(this).addClass('active');
        loadContacts($(this).data('filter'));
    });

    function loadContent(page) {
        let url;
        switch(page) {
            case 'home':
                url = 'views/home.php';
                break;
            case 'users':
                url = 'views/users.php';
                break;
            case 'new-contact':
                url = 'views/new-contact.php';
                break;
            default:
                url = 'views/home.php';
        }

        $('#dashboard-content').load(url);
    }

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
});