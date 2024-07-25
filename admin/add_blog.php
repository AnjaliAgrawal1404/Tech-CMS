<?php
// Include database configuration file
include 'includes/db_config.php';

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: .././login.php "); // Redirect to login page if not logged in
    exit();
} else {
    // Check if the form is submitted
    if (isset($_POST['add'])) {
        // Get form data and sanitize it
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $content = mysqli_real_escape_string($conn, $_POST['content']);
        $blog_image = $_FILES['blog_image']['name'];
        $category = $_POST['category'];

        // Get user ID from the session email
        $get_user_id = "select user_id from user where email= '{$_SESSION['email']}'";
        $result = mysqli_query($conn, $get_user_id);
        $id = mysqli_fetch_assoc($result);
        $user_id = $id['user_id'];

        // SQL query to insert blog data into the database
        $sql = "INSERT INTO blog (blog_title, blog_description, blog_image, category_id, user_id) VALUES ('$title', '$content', '$blog_image', '$category', '$user_id')";

        // Handle image upload
        $tempname = $_FILES["blog_image"]["temp_name"];
        $folder = ".././../uploads/" . $blog_image;
        if (move_uploaded_file($tempname, $folder)) {
            // Execute the query and check for success
            if (mysqli_query($conn, $sql)) {
               echo '<script>alert("Blog Added Successfully");
                window.location.href = "view_blog.php";
                </script>';
            } else {
               echo '<script>alert("Oops!!Failed to upload!!");
   window.location.href = "view_blog.php";
   </script>';
            }
        } else {
            // If image upload fails
            echo '<script>alert("Failed to upload image! Retry!");
  window.location.href = "add_blog.php";
  </script>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Blog</title>
    <link rel="stylesheet" href="css/sidebar.css">
    <?php
    // Include header file
    include 'includes/header.php';
    ?>
</head>
<body>
    <div class="s-layout">
        <!-- Sidebar -->
        <?php
        // Include sidebar file
        include 'includes/sidebar.php';
        ?>
        <!-- Content -->
        <main class="s-layout__content p-0">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="text-center">Add Your Blog</h3>
                        <!-- Form to add a new blog post -->
                        <form method="post" role="form" id="blogForm" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="categorySelect">Category</label>
                                <select class="form-control" id="category" name="category">
                                    <option value="" disabled selected>Select Category</option>
                                    <?php
                                    // Fetch categories from the database
                                    $category_fetch = "select * from category where deleted_at='0000-00-00 00:00:00'";
                                    $result = mysqli_query($conn, $category_fetch);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $selected = ($row['category_name'] == $_POST['category']) ? 'selected' : '';
                                        echo ' <option value="' . $row['category_id'] . '"' . $selected . '>' . $row["category_name"] . '</option> ';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Title" />
                            </div>
                            <div class="form-group">
                                <label for="bimgs">Image</label>
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <span class="btn btn-primary btn-file">
                                            Browse <input type="file" id="blog_image" name="blog_image">
                                        </span>
                                    </span>
                                    <input type="text" class="form-control" id="bimgs-filename" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="content">Description</label>
                                <textarea class="form-control bcontent" id="content" name="content" rows="10"></textarea>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="add" value="Publish" class="btn btn-primary form-control" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <!-- Include external JS files -->
    <script src="js/myscript.js"></script>
    <script src="js/validation.js"></script>
</body>

</html>
