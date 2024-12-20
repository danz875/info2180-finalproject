(function($) {
    // Make loadPage function globally accessible
    window.loadContent = function(page, params = {}) {
        let url;
        switch(page) {
            case 'home':
                url = 'views/home.php';
                break;
            case 'users':
                url = 'views/users.php';
                break;
            case 'new-contact':
                url = 'views/new_contact.php';
                break;
            case 'add-user':
                url = 'views/add_user.php';
                break;
            case 'view-contact':
                url = `views/view_contact.php?id=${params.id}`;
                break;
            default:
                url = 'views/home.php';
        }

        $('#dashboard-content').load(url, function(response, status, xhr) {
            if (status === 'success') {
                // Load CSS first
                if (page === 'home') {
                    $('head').append('<link rel="stylesheet" href="assets/css/home.css">');
                    setTimeout(function() {
                        $.getScript('assets/js/home.js');
                    }, 100);
                }
                else if (page === 'users') {
                    $('head').append('<link rel="stylesheet" href="assets/css/users.css">');
                    setTimeout(function() {
                        $.getScript('assets/js/users.js');
                    }, 100);
                }
                else if (page === 'add-user') {
                    $('head').append('<link rel="stylesheet" href="assets/css/add_user.css">');
                    setTimeout(function() {
                        $.getScript('assets/js/users.js');
                    }, 100);
                }
                else if (page === 'new-contact') {
                    $('head').append('<link rel="stylesheet" href="assets/css/add_user.css">');
                    setTimeout(function() {
                        $.getScript('assets/js/users.js');
                    }, 100);
                }
                else if (page === 'view-contact') {
                    $('head').append('<link rel="stylesheet" href="assets/css/styles.css">');
                }
            }
        });
    };

    // Document ready handler
    $(function() {
        // Load default content
        loadContent('home');

        // Handle navigation clicks
        $('.nav-links a').click(function(e) {
            e.preventDefault();
            $('.nav-links a').removeClass('active');
            $(this).addClass('active');

            const page = $(this).data('page');
            loadContent(page);
        });

        // Handle events from loaded content
        $(document).on('click', '[data-page="view-contact"]', function(e) {
            e.preventDefault();
            const contactId = $(this).data('id');
            loadContent('view-contact', { id: contactId });
        });
    });

    // Add logout handler
    $(document).ready(function() {
        $('a[href="logout.php"]').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: 'logout.php',
                method: 'POST',
                success: function() {
                    window.location.href = 'login.php';
                }
            });
        });
    });
})(jQuery);