<?php
// Include database configuration file
include 'includes/db_config.php';

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    // Redirect to login page if not logged in
    header("Location: .././login.php ");
    exit();
} else {
    // Check if an ID is provided in the URL
    if ($_GET['id']) {
        $id = $_GET['id'];

        // Fetch the blog record based on ID
        $sql = "SELECT * FROM blog WHERE blog_id='$id'";
        $result = mysqli_query($conn, $sql);
        
        // If a record is found
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);

            // Fetch category name for the blog
            $get_category_name = "SELECT category_name FROM category WHERE category_id = '{$row['category_id']}'";
            $category = mysqli_query($conn, $get_category_name);
            $category_name = mysqli_fetch_assoc($category);
        }
    }

    // Check if the form is submitted
    if (isset($_POST['update'])) {
        $id = $_POST['blog_id'];
        $category_id = $_POST['category'];
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $content = mysqli_real_escape_string($conn, $_POST['content']);
        $blog_image = $_FILES['blog_img']['name'];
        $oldimg = $_POST['old_image'];
        $published_status = 0;
        $updated_at = date('Y-m-d H:i:s');

        // Check if a new image is uploaded
        if ($blog_image != '') {
            $update_file = $_FILES["blog_img"]["name"];
        } else {
            // Use old image if no new image is uploaded
            $update_file = $oldimg;
        }

        // Update the blog record
        $query = "UPDATE blog SET category_id ='$category_id', blog_title='$title', blog_description='$content', blog_image='$update_file', published_status='$published_status', updated_at='$updated_at' WHERE blog_id='$id'";

        // Execute the query
        if (mysqli_query($conn, $query)) {
            // If a new image was uploaded, move it to the upload directory
            if ($blog_image != '') {
                move_uploaded_file($_FILES["blog_img"]["tmp_name"], '.././../uploads/' . $update_file);
                // Delete the old image if it exists
                if (file_exists('.././../uploads/' . $oldimg)) {
                    unlink('.././../uploads/' . $oldimg);
                }
            }
            // Success message
            echo '<script>
    alert("Blog Updated Successfully");
    window.location.href = "view_blog.php";
</script>';
        } else {
            // Failure message
            echo '<script>
    alert("Blog details are not updated");
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
    // Include the header
    include 'includes/header.php';
    ?>
</head>
<body>
    <div class="s-layout">
        <!-- Sidebar -->
        <?php
        // Include the sidebar
        include 'includes/sidebar.php';
        ?>
        <!-- Content -->
        <main class="s-layout__content p-0">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="text-center">Update Your Blog</h3>
                        <form method="post" role="form" id="blogForm" enctype="multipart/form-data">
                            <!-- Hidden fields for blog ID and old image -->
                            <input type="hidden" name="blog_id" value="<?= $row['blog_id'] ?>">
                            <input type="hidden" name="old_image" value="<?= $row['blog_image'] ?>">

                            <!-- Display current blog image -->
                            <div class="form-group">
                                <img class="" width="150px" height="150px" src=".././../uploads/<?php echo $row['blog_image']; ?>" alt="">
                            </div>

                            <!-- Category selection -->
                            <div class="form-group">
                                <label for="categorySelect">Category</label>
                                <select class="form-control" id="category" name="category">
                                    <option value="" disabled selected>Select Category</option>
                                    <?php
                                    // Fetch categories for selection
                                    $category_fetch = "SELECT * FROM category WHERE deleted_at='0000-00-00 00:00:00'";
                                    $result1 = mysqli_query($conn, $category_fetch);
                                    while ($row1 = mysqli_fetch_assoc($result1)) {
                                        // Mark the current category as selected
                                        $selected = ($row1['category_name'] == $category_name['category_name']) ? 'selected' : '';
                                        echo '<option value="' . $row1['category_id'] . '"' . $selected . '>' . $row1["category_name"] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <!-- Title input -->
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="<?php echo $row['blog_title'] ?>" />
                            </div>

                            <!-- Image upload -->
                            <div class="form-group">
                                <label for="bimgs">Image</label>
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <span class="btn btn-primary btn-file">
                                            Browse <input type="file" name="blog_img" id="blog_image">
                                        </span>
                                    </span>
                                    <input type="text" class="form-control" id="bimgs-filename" readonly value="<?php echo $row['blog_image'] ?>">
                                </div>
                            </div>

                            <!-- Description input -->
                            <div class="form-group">
                                <label for="content">Description</label>
                                <textarea class="form-control bcontent" id="content" name="content" rows="10"><?php echo $row['blog_description'] ?></textarea>
                            </div>

                            <!-- Submit button -->
                            <div class="form-group">
                                <input type="submit" name="update" value="Publish" class="btn btn-primary form-control" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="js/myscript.js"></script>
    <script src="js/validation.js"></script>
</body>

</html>
