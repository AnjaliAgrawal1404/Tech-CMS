<!-- Link to favicon -->
<link rel="icon" href="../../uploads/favicon.ico" type="image/x-icon">

<!-- Link to Bootstrap CSS for styling -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<!-- Link to Font Awesome for icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

<!-- Link to custom stylesheet -->
<link rel="stylesheet" href="css/index.css">

<!-- Include jQuery library (slim version) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

<!-- Include Popper.js for Bootstrap tooltips and popovers -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>

<!-- Include Bootstrap JavaScript for interactive components -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Include jQuery Validation plugin -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>

<!-- Navigation bar -->
<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
    <!-- Brand name with link -->
    <a class="navbar-brand" href="#">TECH CMS</a>
    
    <!-- Toggler button for responsive navbar -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    
    <!-- Navbar links -->
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto ps-3">
            <?php
            // Check if the user is logged in
            if (isset($_SESSION['email'])) {
                // Display profile and logout links
                echo '
      <li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>
            <li class="nav-item"><a class="nav-link" href=".././logout.php">Logout</a></li>
    ';
            } else {
                // Redirect to login page if not logged in
                header("Location: .././login.php ");
                exit();
            }
            ?>
        </ul>
    </div>
</nav>
