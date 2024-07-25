<?php
// Include database configuration file
include 'includes/db_config.php';

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // Redirect to login page if the user is not logged in
    header("Location:login.php");
    exit();
}

// Check if the delete action is requested
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $deleted_at = date('Y-m-d H:i:s'); // Get the current date and time

    // Update the user entry to mark it as deleted based on the user's email
    $query = "UPDATE user SET deleted_at='$deleted_at' WHERE email='{$_SESSION['email']}'";

    // Execute the query and check if the deletion was successful
    if (mysqli_query($conn, $query)) {
        session_destroy(); // Destroy the session after deleting the profile
        // Display a success message and redirect to the index page
        echo '<script>
            alert("Profile deleted successfully");
            window.location.href = "index.php";
        </script>';
    } else {
        // Display an error message and redirect to the profile page
        echo '<script>
            alert("Profile not deleted");
            window.location.href
 alert("Profile not deleted");
            window.location.href = "profile.php";
        </script>';
    }
}
