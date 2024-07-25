<?php
// Include database configuration and email sending functions
include 'includes/db_config.php';
include 'includes/user_sendmail.php';

// Forgot password code
if (isset($_POST['next'])) {

    // Get the email address from the form
    $email = $_POST['email'];
    // Store the email in session for further steps
    $_SESSION['forgot_email'] = $email;

    // Query to find the user with the given email and not marked as deleted
    $sql = "SELECT * FROM user WHERE email= '$email' AND deleted_at = '0000-00-00 00:00:00'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Fetch the user data
        $row = mysqli_fetch_assoc($result);

        // Check if the email exists in the database
        if ($email != $row['email']) {
            // If email not found, show an alert and redirect to login page
            echo '<script>
            alert("Email is not registered. Please register first!");
            window.location.href = "login.php";
            </script>';
        } else {
            // Generate a random OTP
            $otp = rand(100000, 999999);
            // Store the OTP in session
            $_SESSION['otp'] = $otp;

            // Prepare email details
            $toEmail = $email;
            $subject = 'Forgot Password OTP';
            $body = 'Dear ' . $row['full_name'] . ',<br><br>Your OTP is: ' . $_SESSION['otp'] . ' <br><br>Best regards,<br>Tech CMS Team.';

            // Send the email
            $result = send_registration_Email($toEmail, $subject, $body);

            // Handle the result of the email sending
            if (!$result) {
                // If email not sent, show an alert and redirect to forgot email page
                echo '<script>
                alert("OTP Not sent. Retry!");
                window.location.href = "forgot_email.php";
                </script>';
            } else {
                // If email sent successfully, show an alert and redirect to OTP verification page
                echo '<script>
                alert("OTP sent successfully. Please check your mail.");
                window.location.href = "forgot_otp.php";
                </script>';
            }
        }
    } else {
        // If no data found, show an alert and redirect to forgot email page
        echo '<script>
        alert("No data found");
        window.location.href = "forgot_email.php";
        </script>';
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
                    <!-- Forgot password form -->
                    <form action="" id="loginForm" method="post">
                        <h2>Forgot Password</h2>
                        <input type="email" name="email" id="email" placeholder="Email" />
                        <input type="submit" name="next" value="Next" />
                        <input type="submit" name="cancel" class="bg-danger" onclick="window.location.href = 'login.php';" value="Cancel" />
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>

<script src="js/validation.js"></script>

</html>
