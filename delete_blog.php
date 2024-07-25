<?php

// Include database configuration file
include 'includes/db_config.php';

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // Redirect to login page if the user is not logged in
    header("Location:login.php ");
    exit();
} else {
    // Check if the blog ID is provided via the URL
    if ($_GET['id']) {
        $id = $_GET['id']; // Retrieve the blog ID from the URL
        $deleted_at = date('Y-m-d H:i:s'); // Get the current date and time

        // Update the blog entry to mark it as deleted
        $query = "UPDATE blog SET deleted_at='$deleted_at' WHERE blog_id='$id'";

        // Execute the query and check if the deletion was successful
        if (mysqli_query($conn, $query)) {
            // Display a success message and redirect to the blog view page
            echo '<script>
            alert("Blog deleted Successfully");
            window.location.href = "view_blog.php";
            </script>';
        } else {
            // Display an error message and redirect to the blog view page
            echo '<script>
            alert("Blog not deleted");
            window.location.href = "view_blog.php";
            </script>';
        }
    }
}
