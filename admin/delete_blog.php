<?php

// Include database configuration file
include 'includes/db_config.php';

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: .././login.php");
    exit();
} else {
    // Check if 'id' parameter is set in the URL
    if ($_GET['id']) {
        $id = $_GET['id']; // Get the blog ID from the URL
        $deleted_at = date('Y-m-d H:i:s'); // Get the current date and time for 'deleted_at'

        // Prepare the SQL query to update the 'deleted_at' field in the 'blog' table
        $query = "UPDATE blog SET deleted_at='$deleted_at' WHERE blog_id='$id'";
        // print_r($query);exit; // Debugging line (commented out)

        // Execute the query and check if it was successful
        if (mysqli_query($conn, $query)) {
            // If successful, show an alert and redirect to the 'view_blog.php' page
            echo '<script>
            alert("Blog deleted Successfully");
            window.location.href = "view_blog.php";
        </script>';
        } else {
            // If not successful, show an alert and redirect to the 'view_blog.php' page
            echo '<script>
            alert("Blog not deleted");
            window.location.href = "view_blog.php";
        </script>';
        }
    }
}
?>
