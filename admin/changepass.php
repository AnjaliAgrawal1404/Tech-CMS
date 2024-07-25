<?php
// Include database configuration file
include 'includes/db_config.php';

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: .././login.php"); // Redirect to login page if not logged in
    exit();
} else {
    // Get the current password from the database
    $sql = "select password from user where email='{$_SESSION['email']}'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
    } else {
        echo '<script>
        alert("Oops!! Details are not found");
        window.location.href = "index.php";
        </script>';
    }

    // Check if the form is submitted
    if (isset($_POST['change'])) {
        // Get form data
        $current_pwd = $_POST['current_password'];
        $new_pwd = $_POST['new_password'];
        $confirm_pwd = $_POST['confirm_password'];
        $updated_at = date('Y-m-d H:i:s');

        // Validate current password
        if ($current_pwd != $row['password']) {
            echo '<script>
            alert("Your old password does not match. Please enter the correct password");
            window.location.href = "changepass.php";
            </script>';
        } else if ($current_pwd == $new_pwd) {
            echo '<script>
            alert("Your old password and new password are the same. Please enter a new password");
            window.location.href = "changepass.php";
            </script>';
        } else if ($new_pwd != $confirm_pwd) {
            echo '<script>
            alert("New password and confirm password do not match.");
            window.location.href = "changepass.php";
            </script>';
        } else {
            // Update the password in the database
            $query = "UPDATE user SET password='$new_pwd', updated_at='$updated_at' WHERE email='{$_SESSION['email']}'";
            if (mysqli_query($conn, $query)) {
                echo '<script>
                alert("Password Updated Successfully");
                window.location.href = ".././login.php";
                </script>';
            } else {
                echo '<script>
                alert("Password not Updated");
                window.location.href = "changepass.php";
                </script>';
            }
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
                    <!-- Form to change password -->
                    <form action="" method="POST" id="changepasswordForm" enctype="multipart/form-data">
                        <h3 class="text-center">Change Your Password</h3>
                        <input type="hidden" name="old_profile" value="<?= $row['profile'] ?>">

                        <div class="row mt-4">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-3">
                                <div class="form-group">
                                    <label class="">Current Password:</label>
                                    <input type="password" name="current_password" id="current_password" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-3">
                                <div class="form-group">
                                    <label class="">New Password:</label>
                                    <input type="password" name="new_password" id="new_password" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-3">
                                <div class="form-group">
                                    <label class="">Confirm Password:</label>
                                    <input type="password" name="confirm_password" id="confirm_password" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 submit">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" value="Change" name="change">
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
