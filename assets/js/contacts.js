if (!firstname || !lastname || !email || !type) {
    alert('Please fill in all required fields.');
    return;
}

// Basic email validation
var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
if (!emailRegex.test(email)) {
    alert('Please enter a valid email address.');
    return;
}

$.ajax({
    url: 'handlers/add_contact.php',
    type: 'POST',
    data: $('#new-contact-form').serialize(),
    success: function(response) {
        alert(response);
        loadContent('home');
    },
    error: function() {
        alert('Error adding contact');
    }
});