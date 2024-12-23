
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intro.js/7.2.0/introjs.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
     <link rel="stylesheet" href="./assets/css/intro.css">
</head>
<body>
<?= isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'User not logged in' ?>
    <div class="first">
    <?php if (isset($_SESSION['user_id'])): ?>
        <div class="logout">
            <a href="?route=logout">Logout</a>
        </div>
    <?php endif; ?>

        <h2>Welcome to Classroom!</h2>
        <p>This platform is designed to help you manage and share your classroom materials.</p>
    </div>
    <a href="?route=subject">Subject</a>
    <a href="?route=login">login</a>
    <div class="second">
        <p>Plus</p>
    </div>
    <div class="third">
        <p>Box</p>
    </div>
    <?php include('./includes/scripts.php')?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intro.js/7.2.0/intro.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="./assets/js/intro.js"></script>
</body>
</html>