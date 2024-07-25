<?php
// Include necessary files
include 'includes/db_config.php';
include 'includes/user_sendmail.php';

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location:login.php ");
    exit();
} else {
    // Check if the form has been submitted
    if (isset($_POST['add'])) {
        // Sanitize and retrieve form inputs
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $content = mysqli_real_escape_string($conn, $_POST['content']);
        $blog_image = $_FILES['blog_image']['name'];
        $category = $_POST['category'];

        // Get user details from the database using the session email
        $get_user_id = "select user_id, full_name from user where email= '{$_SESSION['email']}'";
        $result = mysqli_query($conn, $get_user_id);
        $id = mysqli_fetch_assoc($result);

        $user_id = $id['user_id'];
        $author_name = $id['full_name'];

        // SQL query to insert the blog post into the database
        $sql = "INSERT INTO blog (blog_title, blog_description, blog_image, category_id, user_id) VALUES ('$title', '$content', '$blog_image', '$category', '$user_id')";

        // Move uploaded file to the uploads directory
        $tempname = $_FILES["blog_image"]["tmp_name"];
        $folder = "./../uploads/" . $blog_image;
        if (move_uploaded_file($tempname, $folder)) {
            // Execute the SQL query
            if (mysqli_query($conn, $sql)) {
                // Prepare email notification to the admin
                $author_email = $_SESSION['email'];
                $subject = "New Blog Post Added: " . $title;
                $body = "
                <h1>New Blog Post Submission</h1>
                <p><strong>Title:</strong> $title</p>
                <p><strong>Author:</strong> $author_name</p>
                <p><strong>Author's Email:</strong> $author_email</p>
                <p><strong>Content:</strong></p>
                <p>$content</p>
                <hr>
                <p>This is an automated message to notify you of a new blog post submission on your site.</p>
                <p>Please review the content and publish it if it meets your guidelines.</p>
                <p>Best regards,<br>Tech CMS</p>
                ";
                // Send email to admin
                $emailResult = send_addblog_Email($subject, $body, $author_email, $author_name);

                // Check if the email was sent successfully
                if (!$emailResult) {
                    echo "Email could not be sent. Error: $emailResult";
                } else {
                    echo '<script>alert("Blog Added Successfully");
                    window.location.href = "view_blog.php";
                    </script>';
                }
            } else {
                // Display an error message if the blog post could not be added
                echo '<script>alert("Oops!! Failed to upload!!");
                window.location.href = "view_blog.php";
                </script>';
            }
        } else {
            // Display an error message if the image could not be uploaded
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
    // Include the header
    include 'includes/header.php';
    ?>
</head>

<body>
    <div class="s-layout">
        <!-- Sidebar -->
        <?php
        include 'includes/sidebar.php';
        ?>
        <!-- Content -->
        <main class="s-layout__content p-0">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="text-center">Add Your Blog</h3>
                        <!-- Blog submission form -->
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
                                        echo '<option value="' . $row['category_id'] . '"' . $selected . '>' . $row["category_name"] . '</option>';
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
    <!-- Include custom JavaScript files -->
    <script src="js/myscript.js"></script>
    <script src="js/validation.js"></script>
</body>

</html>