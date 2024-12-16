// assets/js/dashboard.js
$(document).ready(function() {
    // Load default content (home)
    loadContent('home');

    // Handle navigation clicks
    $('.nav-links a').click(function(e) {
        e.preventDefault();
        $('.nav-links a').removeClass('active');
        $(this).addClass('active');

        const page = $(this).data('page');
        loadContent(page);
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

        $('#dashboard-content').load(url, function() {
            // Load home.js if the home page is loaded
            if (page === 'home') {
                $('head').append('<link rel="stylesheet" href="assets/css/home.css">');
                $.getScript('assets/js/home.js');
            }
        });
    }
});