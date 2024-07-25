<?php

// Include database configuration file
include 'includes/db_config.php';

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: .././login.php"); // Redirect to login page if not logged in
    exit();
} else {
    // Check if 'id' parameter is set in the URL
    if ($_GET['id']) {
        $id = $_GET['id']; // Get the ID from the URL
        $deleted_at = date('Y-m-d H:i:s'); // Get the current date and time for 'deleted_at'
        
        // Prepare the SQL query to update the 'deleted_at' field in the 'user' table
        $query = "UPDATE user SET deleted_at='$deleted_at' WHERE user_id='$id'";
        
        // Execute the query and check if it was successful
        if (mysqli_query($conn, $query)) {
            // If successful, show an alert and redirect to the 'view_author.php' page
            echo '<script>
            alert("Author deleted Successfully");
            window.location.href = "view_author.php";
        </script>';
        } else {
            // If not successful, show an alert and redirect to the 'view_author.php' page
            echo '<script>
            alert("Author not deleted");
            window.location.href = "view_author.php";
        </script>';
        }
    }
}
?>
