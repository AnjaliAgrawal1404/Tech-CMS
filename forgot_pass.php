<?php
// Include database configuration and email sending functions
include 'includes/db_config.php';
include 'includes/user_sendmail.php';

// Check if the forgot email is set in the session
if (!isset($_SESSION['forgot_email'])) {
    // Redirect to the forgot email page if forgot email is not set
    header("Location:forgot_email.php");
    exit();
} else {
    // Handle the form submission for password change
    if (isset($_POST['change'])) {
        $email = $_SESSION['forgot_email']; // Get the email from the session

        $new_pwd = md5($_POST['new_password']); // Hash the new password
        $confirm_pwd = md5($_POST['confirm_password']); // Hash the confirm password
        $updated_at = date('Y-m-d H:i:s'); // Get the current date and time

        // Check if the new password matches the confirm password
        if ($new_pwd != $confirm_pwd) {
            // If passwords do not match, show an alert and redirect to the password reset page
            echo '<script>
            alert("Password and confirm password do not match.");
            window.location.href = "forgot_pass.php";
            </script>';
        } else {
            // Update the user's password in the database
            $query = "UPDATE user SET password='$new_pwd', updated_at='$updated_at' WHERE email='$email'";

            // Check if the query was successful
            if (mysqli_query($conn, $query)) {
                // If successful, show a success message and redirect to the login page
                echo '<script>
                alert("Password Changed Successfully");
                window.location.href = "login.php";
                </script>';
                // Unset the forgot email from the session
                unset($_SESSION['forgot_email']);
            } else {
                // If query failed, show an alert and redirect to the password reset page
                echo '<script>
                alert("Password not updated! Please retry.");
                window.location.href = "forgot_pass.php";
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
    <title>Forgot Password</title>
    <link rel="stylesheet" href="css/login.css">
    <script src="js/myscript.js"></script>
    <?php
    // Include the header
    include 'includes/header.php';
    ?>
</head>

<body>
    <section>
        <div class="container">
            <div class="user signinBx">
                <div class="imgBx"><img src="image/login.jpg" alt="" /></div>
                <div class="formBx">
                    <!-- Password reset form -->
                    <form action="" id="changepasswordForm" method="post">
                        <h2>Forgot Password</h2>
                        <input type="password" name="new_password" id="new_password" placeholder="New Password" />
                        <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" />
                        <input type="submit" name="change" value="Change" />
                        <input type="submit" name="cancel" class="bg-danger" onclick="window.location.href = 'forgot_email.php';" value="Cancel" />
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>

<script src="js/validation.js"></script>

</html>