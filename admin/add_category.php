<?php 
// Include database configuration file
include 'includes/db_config.php';

// Check if the user is logged in
if(!isset($_SESSION['email'])) {
    header("Location: .././login.php "); // Redirect to login page if not logged in
    exit();
} else {
    // Check if the form is submitted
    if(isset($_POST['add'])) {
        // Get category name from the form
        $category_name = $_POST['category_name'];

        // SQL query to insert the category into the database
        $sql = "insert into category(category_name) values ('$category_name')";

        // Execute the query and check for success
        if (mysqli_query($conn, $sql)) {
            echo '<script>
                alert("Category Added Successfully");
                window.location.href = "view_categories.php";
            </script>';
        } else {
            echo '<script>
                alert("Oops!! Category not Added");
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
    <title>Add Category</title>
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
    <main class="s-layout__content">
        <div class="container">
            <div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-12 col-xs-12 edit_information">
                <!-- Form to add a new category -->
                <form action="" id="categoryForm" method="post">
                    <h3 class="text-center">Add Category</h3>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-3">
                            <div class="form-group">
                                <label class="profile_details_text">Category Name:</label>
                                <input type="text" name="category_name" id="category_name" class="form-control" value="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 submit">
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="Add" name="add">
                                <input type="button" class="btn btn-primary" onclick="window.location='view_categories.php';" value="Cancel">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>
<!-- Include validation script -->
<script src="js/validation.js"></script>
</body>
</html>
