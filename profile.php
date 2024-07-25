<?php
include 'includes/db_config.php'; // Include database configuration file

// Check if the user is logged in by checking the session email
if (!isset($_SESSION['email'])) {
    header("Location:login.php "); // Redirect to login page if not logged in
    exit();
} else {
    // Fetch user details from the database based on the session email
    $sql = "SELECT * FROM user WHERE email='{$_SESSION['email']}'";
    $result = mysqli_query($conn, $sql);

    // If user is found
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result); // Fetch user details
    } else {
        // Alert and redirect if user details are not found
        echo '<script>
            alert("Oops!! Details are not found");
            window.location.href = "index.php";
        </script>';
        exit(); // Stop further execution
    }

    // Update profile if the form is submitted
    if (isset($_POST['update'])) {
        $full_name = $_POST['full_name']; // Get the full name from the form
        $profile = $_FILES["profile"]["name"]; // Get the uploaded profile image name
        $updated_at = date('Y-m-d H:i:s'); // Get the current timestamp
        $oldprofile = $_POST['old_profile']; // Get the old profile image name

        // Check if a new profile image is selected
        if ($profile != '') {
            $update_file = $profile; // New profile image name
        } else {
            $update_file = $oldprofile; // Keep the old profile image name
        }

        // Update the user profile information in the database
        $query = "UPDATE user SET full_name='$full_name', profile='$update_file', updated_at='$updated_at' WHERE email='{$_SESSION['email']}'";
        $update_profile = mysqli_query($conn, $query);

        if ($update_profile) {
            // If a new profile image is uploaded, move the file and delete the old image
            if ($profile != '') {
                move_uploaded_file($_FILES["profile"]["tmp_name"], './../uploads/' . $update_file);
                if (file_exists('./../uploads/' . $oldprofile) && $oldprofile != '') {
                    unlink('./../uploads/' . $oldprofile); // Delete the old profile image
                }
            }
            // Success message and redirect
            echo '<script>
                alert("Author profile updated successfully");
                window.location.href = "profile.php";
            </script>';
        } else {
            // Error message and redirect
            echo '<script>
                alert("Author profile not updated");
                window.location.href = "profile.php";
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
    <title>Profile</title>
    <link rel="stylesheet" href="css/sidebar.css"> <!-- Link to custom CSS for the sidebar -->
    <script src="js/myscript.js"></script> <!-- Link to custom JavaScript -->
    <?php include 'includes/header.php'; ?> <!-- Include header file -->
</head>

<body>
    <div class="s-layout">
        <!-- Sidebar -->
        <?php include 'includes/sidebar.php'; ?> <!-- Include sidebar file -->

        <!-- Content -->
        <main class="s-layout__content">
            <div class="container">
                <div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-12 col-xs-12 edit_information">
                    <form action="" method="POST" id="profileForm" enctype="multipart/form-data">
                        <h3 class="text-center">Edit Personal Information</h3>
                        <input type="hidden" name="old_profile" value="<?= $row['profile'] ?>"> <!-- Hidden field for old profile image -->

                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mb-3">
                                <!-- Display current profile image -->
                                <img src="./../uploads/<?php echo $row['profile']; ?>" class="rounded-circle" style="margin-left: 202px;" width="70px" height="70px" alt="">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-3">
                                <div class="form-group">
                                    <label class="profile_details_text">Full Name:</label>
                                    <input type="text" name="full_name" id="full_name" class="form-control" value="<?php echo $row['full_name'] ?>"> <!-- Input for full name -->
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-3">
                                <div class="form-group">
                                    <label class="profile_details_text">Email Address:</label>
                                    <input type="email" name="email" id="email" class="form-control" value="<?php echo $row['email'] ?>" readonly> <!-- Read-only email input -->
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 submit mb-2">
                                <div class="form-group">
                                    <input type="file" name="profile" id="profile"> <!-- Input for new profile image -->
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 submit">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" value="Update" name="update"> <!-- Submit button for updating profile -->
                                    <button class="btn btn-danger" onclick="confirmDelete(event)">Delete Profile</button> <!-- Button to confirm profile deletion -->
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
<script src="js/validation.js"></script> <!-- Link to custom JavaScript for validation -->

</html>