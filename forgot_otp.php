<?php
// Include database configuration and email sending functions
include 'includes/db_config.php';
include 'includes/user_sendmail.php';

// Check if the OTP is set in the session
if (!isset($_SESSION['otp'])) {
    // Redirect to the forgot email page if OTP is not set
    header("Location:forgot_email.php");
    exit();
} else {
    // Handle the form submission for OTP verification
    if (isset($_POST['next'])) {
        $otp = $_POST['otp']; // Get the OTP from the form

        // Check if the entered OTP matches the OTP stored in the session
        if ($_SESSION['otp'] != $otp) {
            // If OTP does not match, show an alert and redirect to the OTP entry page
            echo '<script>
            alert("OTP not matched! Please enter the correct OTP.");
            window.location.href = "forgot_otp.php";
            </script>';
        } else {
            // If OTP matches, show a success message and redirect to the password reset page
            echo '<script>
            alert("OTP verified successfully.");
            window.location.href = "forgot_pass.php";
            </script>';
            // Unset the OTP from the session
            unset($_SESSION['otp']);
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
                    <!-- OTP verification form -->
                    <form action="" id="otpForm" method="post">
                        <h2>Forgot Password</h2>
                        <input type="number" name="otp" id="otp" placeholder="OTP" />
                        <input type="submit" name="next" value="Next" />
                        <input type="submit" name="cancel" class="bg-danger" onclick="window.location.href = 'forgot_email.php';" value="Cancel" />
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>

<script src="js/validation.js"></script>

</html>