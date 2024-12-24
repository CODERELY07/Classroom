<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intro.js/7.2.0/introjs.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./assets/css/intro.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
</head>
<body>
    <?php //isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'User not logged in' ?>

    <div class="first">
    <?php if (isset($_SESSION['user_id'])): ?>
        <div class="logout">
            <a href="?route=logout">Logout</a>
        </div>
    <?php endif; ?>
        <h2>Welcome to Classroom!</h2>
        <p>This platform is designed to help you manage and share your classroom materials.</p>
    </div>

    <!-- Button to Open the Modal for Join Class -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#codeModal">
        Join class
    </button>
    <?php
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'Teacher'):
        ?>
        <!-- Button to Open the Modal for Create Class -->
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createClassModal">
            Create Class
        </button>
    <?php endif;?>
    <div id="classList">

    </div>
    <div id="studentClassList">
        
    </div>
    <?php include('./partials/createClass.php')?>
    <?php include('./partials/joinClass.php')?>
    <?php include('./includes/scripts.php')?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intro.js/7.2.0/intro.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="./assets/js/intro.js"></script>
</body>
</html>
