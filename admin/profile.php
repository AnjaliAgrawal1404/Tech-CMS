<?php
// Include the database configuration file
include 'includes/db_config.php';

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: .././login.php");
    exit();
} else {
    // Query to get the current user details based on their email
    $sql = "SELECT * FROM user WHERE email='{$_SESSION['email']}'";
    $result = mysqli_query($conn, $sql);
    // Fetch user details if the result is not empty
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
    } else {
        // Alert and redirect if user details are not found
        echo '<script>
        alert("Oops!!Details are not found");
        window.location.href = "index.php";
        </script>';
    }

    // Check if the form has been submitted
    if (isset($_POST['update'])) {
        $full_name = $_POST['full_name'];
        $profile = $_FILES["profile"]["name"]; // Get the profile image name
        $updated_at = date('Y-m-d H:i:s');
        $oldprofile = $_POST['old_profile']; // Get the old profile image name

        // Determine whether to use the new image or keep the old one
        if ($profile != '') {
            $update_file = $_FILES["profile"]["name"];
        } else {
            $update_file = $oldprofile;
        }

        // Update the user details in the database
        $query = "UPDATE user SET full_name='$full_name', profile='$update_file', updated_at='$updated_at' WHERE email='{$_SESSION['email']}'";
        $update_profile = mysqli_query($conn, $query);

        // Check if the update was successful
        if ($update_profile) {
            // If a new image was uploaded, move it to the uploads directory and delete the old image
            if ($profile != '') {
                move_uploaded_file($_FILES["profile"]["tmp_name"], '.././../uploads/' . $update_file);
                if (file_exists('.././../uploads/' . $oldprofile)) {
                    unlink('.././../uploads/' . $oldprofile);
                }
            }
            // Alert and redirect if the update was successful
            echo '<script>
            alert("Admin profile Updated Successfully");
            window.location.href = "profile.php";
            </script>';
        } else {
            // Alert and redirect if the update failed
            echo '<script>
            alert("Admin profile not Updated");
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
    <!-- Include sidebar CSS -->
    <link rel="stylesheet" href="css/sidebar.css">
    <!-- Include the header file -->
    <?php include 'includes/header.php'; ?>
</head>
<body>
    <div class="s-layout">
        <!-- Include the sidebar -->
        <?php include 'includes/sidebar.php'; ?>
        
        <!-- Content area -->
        <main class="s-layout__content">
            <div class="container">
                <div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-12 col-xs-12 edit_information">
                    <!-- Profile update form -->
                    <form action="" method="POST" id="profileForm" enctype="multipart/form-data">
                        <h3 class="text-center">Edit Personal Information</h3>
                        <!-- Hidden field to store the old profile image name -->
                        <input type="hidden" name="old_profile" value="<?= $row['profile'] ?>">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mb-3">
                                <!-- Display the current profile image -->
                                <img src=".././../uploads/<?php echo $row['profile']; ?>" class="rounded-circle" style="margin-left: 202px;" width="70px" height="70px" alt="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-3">
                                <div class="form-group">
                                    <label class="profile_details_text">Full Name:</label>
                                    <!-- Input field for full name -->
                                    <input type="text" name="full_name" id="full_name" class="form-control" value="<?php echo $row['full_name'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-3">
                                <div class="form-group">
                                    <label class="profile_details_text">Email Address:</label>
                                    <!-- Input field for email address (readonly) -->
                                    <input type="email" name="email" id="email" class="form-control" value="<?php echo $row['email'] ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 submit mb-2">
                                <div class="form-group">
                                    <!-- File input for profile image -->
                                    <input type="file" name="profile" id="profile">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 submit">
                                <div class="form-group">
                                    <!-- Submit button to update profile -->
                                    <input type="submit" class="btn btn-primary" value="Update" name="update">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
<!-- Include validation script -->
<script src="js/validation.js"></script>
</html>
