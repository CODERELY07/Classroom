$(document).ready(function() {
    function fetchClasses() {
        $.ajax({
            url: './partials/fetchTeacherClasses.php',  // PHP script to fetch classes
            type: 'GET',
            success: function(response) {
                // Update the classes list with the new data
                $("#classList").html(response);
            },
            error: function() {
                alert('Error fetching classes.');
            }
        });
    }

    function fetchStudetClasses() {
        $.ajax({
            url: './partials/fetchStudentClasses.php',  // PHP script to fetch classes
            type: 'GET',
            success: function(response) {
                // Update the classes list with the new data
                $("#studentClassList").html(response);
            },
            error: function() {
                alert('Error fetching classes.');
            }
        });
    }
    fetchStudetClasses();
    fetchClasses();

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

    

    // Create Classroom
    $("#createClassForm").on('submit', function(e) {
        e.preventDefault();  // Prevent the default form submission
    
        // Collect form data
        var formData = {
            className: $("#className").val(),
            section: $("#section").val(),
            subject: $("#subject").val()
        };
    
        // Send AJAX request to the PHP server
        $.ajax({
            type: "POST",
            url: './auth/create_class.php',  // PHP script to handle class creation
            data: formData,  // Form data to send
            success: function(response) {
            
                alert(response);  // Display response message (for example, success or error message)
    
                // Reset the form fields
                $("#createClassForm")[0].reset();
              
                fetchClasses();  
            },
            error: function(xhr, status, error) {
                // Handle errors if any
                console.log("Error: " + status + " " + error);
                alert("An error occurred while creating the class.");
            }
        });
    });
    


    // Handle the join class form submission
    $('#joinClassForm').on('submit', function(e) {
        e.preventDefault();  // Prevent form from submitting normally
        console.log("join");
        var classCode = $('#classCode').val();
        var errorMessage = $('#errorMessage');

        // Clear any previous error messages
        errorMessage.hide().text('');

        // Send an AJAX request to join the class
        $.ajax({
            url: './auth/join_class.php', // Replace with your PHP file
            method: 'POST',
            data: { classCode: classCode },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // Show success message and hide the modal
                    alert(response.message);  // You can replace with a more styled message
                    fetchStudetClasses();
                } else {
                    // Show error message
                    errorMessage.text(response.message).show();
                }
            },
            error: function() {
                errorMessage.text('An error occurred. Please try again later.').show();
            }
        });
    });
    
    

});
