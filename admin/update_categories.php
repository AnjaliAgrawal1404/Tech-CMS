<?php
// Include database configuration file
include 'includes/db_config.php';

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    // Redirect to login page if user is not logged in
    header("Location: .././login.php ");
    exit();
} else {
    // Check if an ID is provided in the URL
    if ($_GET['id']) {
        $id = $_GET['id'];

        // Fetch the category record based on ID
        $sql = "SELECT * FROM category WHERE category_id='$id'";
        $result = mysqli_query($conn, $sql);

        // If a record is found
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
        }
    }

    // Check if the form is submitted
    if (isset($_POST['update'])) {
        $category_name = $_POST['category_name'];
        $updated_at = date('Y-m-d H:i:s');

        // Update the category record
        $query = "UPDATE category SET category_name='$category_name', updated_at='$updated_at' WHERE category_id='$id'";

        // Execute the query
        if (mysqli_query($conn, $query)) {
            // Success message and redirect to view categories page
            echo '<script>
    alert("Category Updated Successfully");
    window.location.href = "view_categories.php";
</script>';
        } else {
            // Failure message and redirect to view categories page
            echo '<script>
    alert("Category not Updated");
    window.location.href = "view_categories.php";
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
    <title>Update Category</title>
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
        <main class="s-layout__content">
            <div class="container">
                <div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-12 col-xs-12 edit_information">
                    <form action="" method="POST" id="categoryForm">
                        <h3 class="text-center">Update Category</h3>

                        <!-- Category name input -->
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-3">
                                <div class="form-group">
                                    <label class="profile_details_text">Category Name:</label>
                                    <input type="text" name="category_name" id="category_name" class="form-control" value="<?= $row['category_name'] ?>">
                                </div>
                            </div>
                        </div>

                        <!-- Submit and Cancel buttons -->
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 submit">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" value="Update" name="update">
                                    <input type="button" class="btn btn-primary" onclick="window.location='view_categories.php';" value="Cancel">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
<!-- Include validation JavaScript -->
<script src="js/validation.js"></script>
</html>
