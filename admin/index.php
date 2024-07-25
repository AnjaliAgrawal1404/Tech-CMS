<?php 
// Include the database configuration file
include 'includes/db_config.php';

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: .././login.php");
    exit();
} else {
    // Query to get the count of authors who are not marked as deleted
    $sql = "SELECT * FROM user WHERE role='Author' AND deleted_at = '0000-00-00 00:00:00'";
    $result = mysqli_query($conn, $sql);
    $author = mysqli_num_rows($result); // Number of authors

    // Query to get the count of published blogs that are not marked as deleted
    $sql = "SELECT * FROM blog WHERE deleted_at = '0000-00-00 00:00:00' AND published_status='1'";
    $result = mysqli_query($conn, $sql);
    $blog = mysqli_num_rows($result); // Number of blogs

    // Query to get the count of categories that are not marked as deleted
    $sql = "SELECT * FROM category WHERE deleted_at = '0000-00-00 00:00:00'";
    $result = mysqli_query($conn, $sql);
    $category = mysqli_num_rows($result); // Number of categories
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechCMS Admin</title>
   <!-- Your sidebar and main page CSS -->
    <link rel="stylesheet" href="css/sidebar.css"> 
    <link rel="stylesheet" href="css/index.css">
    <!-- Include the header file -->
    <?php include 'includes/header.php'; ?>
</head>
<body>
<div class="s-layout">
    <!-- Include the sidebar -->
    <?php include 'includes/sidebar.php'; ?>
    
    <!-- Main content area -->
    <main class="s-layout__content p-0" style="margin-top:-105px;">
        <div class="container">
            <div class="card-container">
                <!-- Card for Authors -->
                <a href="view_author.php" class="card">
                    <div class="card-icon"><i class="fas fa-user"></i></div>
                    <div class="card-name">Authors</div>
                    <div class="card-count"><?php echo $author; ?></div>
                </a>
                <!-- Card for Blogs -->
                <a href="view_blog.php" class="card">
                    <div class="card-icon"><i class="fas fa-blog"></i></div>
                    <div class="card-name">Blogs</div>
                    <div class="card-count"><?php echo $blog; ?></div>
                </a>
                <!-- Card for Categories -->
                <a href="view_categories.php" class="card">
                    <div class="card-icon"><i class="fas fa-list-alt"></i></div>
                    <div class="card-name">Categories</div>
                    <div class="card-count"><?php echo $category; ?></div>
                </a>
            </div>
        </div>
    </main>
</div>
</body>
</html>
