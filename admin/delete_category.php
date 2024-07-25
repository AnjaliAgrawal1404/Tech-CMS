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
        $id = $_GET['id']; // Get the category ID from the URL
        $deleted_at = date('Y-m-d H:i:s'); // Get the current date and time for 'deleted_at'

        // Prepare the SQL query to update the 'deleted_at' field in the 'category' table
        $query = "UPDATE category SET deleted_at='$deleted_at' WHERE category_id='$id'";
        // print_r($query);exit; // Debugging line (commented out)

        // Execute the query and check if it was successful
        if (mysqli_query($conn, $query)) {
            // If successful, show an alert and redirect to the 'view_categories.php' page
            echo '<script>
            alert("Category deleted Successfully");
            window.location.href = "view_categories.php";
        </script>';
        } else {
            // If not successful, show an alert and redirect to the 'view_categories.php' page
            echo '<script>
            alert("Category not deleted");
            window.location.href = "view_categories.php";
        </script>';
        }
    }
}
?>
