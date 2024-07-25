<?php
// Include the database configuration file
include 'db_config.php';
?>
<!-- Add the favicon -->
<link rel="icon" href="./../uploads/favicon.ico" type="image/x-icon">

<!-- Include Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<!-- Include Font Awesome CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
<!-- Include custom CSS -->
<link rel="stylesheet" href="css/index.css">

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<!-- Include Popper.js for Bootstrap tooltips and popovers -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<!-- Include Bootstrap JavaScript -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Include jQuery Validation plugin -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>

<!-- Navigation bar -->
<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">TECH CMS</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto ps-3">
            <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="post.php">Explore</a></li>
            <?php 
            // Check if the user is logged in
            if (isset($_SESSION['email'])) {
                // If logged in, show the 'Add Blog' link
                echo '<li class="nav-item"><a class="nav-link" href="add_blog.php">Add Blog</a></li>';           
            } else {
                // If not logged in, show the 'Add Blog' link directing to the login page
                echo '<li class="nav-item"><a class="nav-link" href="login.php">Add Blog</a></li>';
            }

            // Check if the user is logged in
            if (isset($_SESSION['email'])) {
                // If logged in, show 'Profile' and 'Logout' links
                echo '
                <li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                ';
            } else {
                // If not logged in, show the 'Login' link
                echo '<li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>';
            }
            ?>
        </ul>
    </div>
</nav>
