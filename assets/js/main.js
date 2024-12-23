$(document).ready(function() {
    // Signup
    $('#signupForm').on('submit', function(event) {
        event.preventDefault(); 
        
        const formData = $(this).serialize();
       
        $.ajax({
            url: './auth/signup_auth.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                $('#responseMessage').text(response); 
            },
            error: function(xhr, status, error) {
                $('#responseMessage').text('An error occurred: ' + error);
            }
        });
    });

    // Login
    $('#loginForm').on('submit', function(event) {
        event.preventDefault(); 
        
        const formData = $(this).serialize();

        $.ajax({
            url: './auth/login_auth.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                try {
                    const res = JSON.parse(response);
                    $('#responseMessage').text(res.message);
                    if (res.success) {
                        window.location.href = res.redirect; 
                    }
                } catch (e) {
                    $('#responseMessage').text('Error parsing response.');
                }
            },
            error: function(xhr, status, error) {
                $('#responseMessage').text('An error occurred: ' + error);
            }
        });
    });
});
