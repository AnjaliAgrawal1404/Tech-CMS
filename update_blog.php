<?php
include 'includes/db_config.php'; // Include the database configuration file
include 'includes/user_sendmail.php'; // Include the send mail script

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location:login.php"); // Redirect to login page if not logged in
    exit();
} else {
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

            // SQL query to fetch the user name using user_id from the blog post
            $get_user_name = "SELECT full_name FROM user WHERE user_id= '{$row['user_id']}'";
            $result = mysqli_query($conn, $get_user_name); // Execute the query
            $name = mysqli_fetch_assoc($result); // Fetch the user name
        }
    }

    // Check if the form is submitted
    if (isset($_POST['update'])) {

        $id = $_POST['blog_id']; // Get the blog ID from the form
        $category_id = $_POST['category']; // Get the selected category ID from the form
        $title = mysqli_real_escape_string($conn, $_POST['title']); // Get and escape the blog title
        $content = mysqli_real_escape_string($conn, $_POST['content']); // Get and escape the blog content
        $blog_image = $_FILES['blog_img']['name']; // Get the blog image name
        $oldimg = $_POST['old_image']; // Get the old image name
        $published_status = 0; // Set the published status to 0
        $updated_at = date('Y-m-d H:i:s'); // Get the current date and time

        // Check if the user has uploaded a new image
        if ($blog_image != '') {
            $update_file = $_FILES["blog_img"]["name"]; // Use the new image name
        } else {
            $update_file = $oldimg; // Use the old image name
        }

        // SQL query to update the blog post
        $query = "UPDATE blog SET category_id ='$category_id', blog_title='$title', blog_description='$content', blog_image='$update_file', published_status='$published_status', updated_at='$updated_at' WHERE blog_id='$id'";

        // Execute the update query
        if (mysqli_query($conn, $query)) {
            // If a new image is uploaded, move it to the uploads directory and delete the old image
            if ($blog_image != '') {
                move_uploaded_file($_FILES["blog_img"]["tmp_name"], '.././../uploads/' . $update_file);
                if (file_exists('.././../uploads/' . $oldimg)) {
                    unlink('.././../uploads/' . $oldimg);
                }
            }

            // Prepare email notification
            $author_email = $_SESSION['email'];
            $author_name = $name['full_name'];

            $subject = "Blog Post Updated: " . $title;
            $body = "
                <h1>Blog Post Updated</h1>
                <p><strong>Blog ID:</strong> $id</p>
                <p><strong>Title:</strong> $title</p>
                <p><strong>Author:</strong> $author_name</p>
                <p><strong>Author's Email:</strong> $author_email</p>
                <p><strong>Updated Content:</strong></p>
                <p>$content</p>
                <hr>
                <p>This is an automated message to notify you of an updated blog post on your site.</p>
                <p>Please review the updated content and publish it if it meets your guidelines.</p>
                <p>Best regards,<br>Tech CMS.</p>
            ";

            // Send email to admin
            $emailResult = send_addblog_Email($subject, $body, $author_email, $author_name);

            // Check if email was sent successfully
            if (!$emailResult) {
                echo "Email could not be sent. Error: $emailResult";
            } else {
                echo '<script>
                        alert("Blog Updated Successfully");
                        window.location.href = "view_blog.php";
                      </script>';
            }
        } else {
            echo '<script>
                    alert("Blog details are not Updated");
                    window.location.href = "view_blog.php";
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
    <title>Update Blog</title>
    <link rel="stylesheet" href="css/sidebar.css">
    <?php
    include 'includes/header.php'; // Include the header file
    ?>
</head>
<body>
    <div class="s-layout">
        <!-- Sidebar -->
        <?php
        include 'includes/sidebar.php'; // Include the sidebar file
        ?>
        <!-- Content -->
        <main class="s-layout__content p-0">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="text-center">Update Your Blog</h3>
                        <form method="post" role="form" id="blogForm" enctype="multipart/form-data">
                            <input type="hidden" name="blog_id" value="<?= $row['blog_id'] ?>"> <!-- Hidden field for blog ID -->
                            <input type="hidden" name="old_image" value="<?= $row['blog_image'] ?>"> <!-- Hidden field for old image name -->
                            <div class="form-group">
                                <img class="" width="150px" height="150px" src=".././../uploads/<?php echo $row['blog_image']; ?>" alt=""> <!-- Display the current blog image -->
                            </div>

                            <div class="form-group">
                                <label for="categorySelect">Category</label>
                                <select class="form-control" id="category" name="category">
                                    <option value="" disabled selected>Select Category</option>
                                    <?php
                                    // Fetch and display categories
                                    $category_fetch = "SELECT * FROM category WHERE deleted_at='0000-00-00 00:00:00'";
                                    $result1 = mysqli_query($conn, $category_fetch);
                                    while ($row1 = mysqli_fetch_assoc($result1)) {
                                        $selected = ($row1['category_name'] == $category_name['category_name']) ? 'selected' : '';
                                        echo '<option value="' . $row1['category_id'] . '"' . $selected . '>' . $row1["category_name"] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="<?php echo $row['blog_title'] ?>"> <!-- Blog title input -->
                            </div>
                            <div class="form-group">
                                <label for="bimgs">Image</label>
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <span class="btn btn-primary btn-file">
                                            Browse <input type="file" name="blog_img" id="blog_image"> <!-- File input for blog image -->
                                        </span>
                                    </span>
                                    <input type="text" class="form-control" id="bimgs-filename" readonly value="<?php echo $row['blog_image'] ?>"> <!-- Display the image file name -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="content">Description</label>
                                <textarea class="form-control bcontent" id="content" name="content" rows="10"><?php echo $row['blog_description'] ?></textarea> <!-- Blog description textarea -->
                            </div>
                            <div class="form-group">
                                <input type="submit" name="update" value="Publish" class="btn btn-primary form-control" /> <!-- Submit button -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="js/myscript.js"></script> <!-- Custom scripts -->
    <script src="js/validation.js"></script> <!-- Validation scripts -->
</body>
</html>
