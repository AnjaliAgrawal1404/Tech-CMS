<?php
include 'includes/db_config.php'; // Include the database configuration file

// Check if 'id' is set in the GET request
if ($_GET['id']) {
  $id = $_GET['id']; // Get the blog post ID from the URL
  $sql = "SELECT * FROM blog WHERE blog_id='$id'"; // SQL query to fetch the blog post by ID
  $result = mysqli_query($conn, $sql); // Execute the query

  // Check if the query returns any result
  if (mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_array($result); // Fetch the result as an associative array

      // SQL query to fetch the category name using category_id from the blog post
      $get_category_name = "SELECT category_name FROM category WHERE category_id = '{$row['category_id']}'";
      $category = mysqli_query($conn, $get_category_name); // Execute the query
      $category_name = mysqli_fetch_assoc($category); // Fetch the category name

      // SQL query to fetch the user details using user_id from the blog post
      $get_user_id = "SELECT full_name, profile FROM user WHERE user_id = '{$row['user_id']}'";
      $user = mysqli_query($conn, $get_user_id); // Execute the query
      $user_id = mysqli_fetch_assoc($user); // Fetch the user details
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blog Post</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <?php 
  include 'includes/header.php'; // Include the header file
  ?>
</head>
<body>
<div class="container-fluid">

  <div class="banner mt-5">
    <img src="./../uploads/<?php echo $row['blog_image']; ?>" alt="Blog Image"> <!-- Display the blog image -->
  </div>

  <div class="single-blog-content">
    <div class="single-blog-post">
      <h2><?php echo $row['blog_title']; ?></h2> <!-- Display the blog title -->
      <p><?php echo $row['blog_description']; ?></p> <!-- Display the blog description -->
      
      <!-- Author Info -->
      <div class="author-info">
        <img src="./../uploads/<?php echo $user_id['profile']; ?>" alt="Author Image"> <!-- Display the author image -->
        <div class="details">
          <i class="fas fa-user"></i><strong><?php echo $user_id['full_name']; ?></strong> <!-- Display the author name -->
        </div>
        <div class="details">
          <i class="fas fa-calendar-alt"></i><span>
            <?php
            // Format and display the creation date of the blog post
            $timestamp = strtotime($row['created_at']);
            $formattedDate = date('d F Y', $timestamp);
            echo $formattedDate;
            ?>
          </span>
        </div>
        <div class="details">
          <i class="fas fa-tag"></i><span><?php echo $category_name['category_name']; ?></span> <!-- Display the category name -->
        </div>
      </div>
    </div>
    <!-- Button to go back to the posts list -->
    <input type="button" class="btn btn-primary mt-4" onclick="window.location='post.php';" value="Back">
  </div>
</div>
</body>
</html>
