<?php
// Include database configuration and email sending functions
include 'includes/db_config.php';
include 'includes/user_sendmail.php';

// Registration code
if (isset($_POST['register'])) {
  $full_name = $_POST['full_name'];
  $email = $_POST['email'];
  $password = md5($_POST['password']); // Hash the password
  $profile = $_FILES["profile"]["name"]; // Get the profile image name
  $role = 'Author'; // Default role is Author

  // Check if the email is unique and not deleted
  $check_unique_email = "SELECT email FROM user WHERE email= '{$_POST['email']}' AND deleted_at = '0000-00-00 00:00:00'";
  $result = mysqli_query($conn, $check_unique_email);

  if (mysqli_num_rows($result) > 0) {
    // If email already exists, show an alert and redirect to login page
    echo '<script>
            alert("Author already exists with this email address.");
            window.location.href = "login.php";
        </script>';
  } else {
    // Insert the new user into the database
    $sql = "INSERT INTO user (full_name, email, password, profile, role) VALUES ('$full_name', '$email', '$password', '$profile', '$role')";
    $tempname = $_FILES["profile"]["tmp_name"]; // Get the temporary file name of the profile image
    $folder = "../uploads/" . $profile; // Set the destination folder for the profile image

    // Move the uploaded profile image to the destination folder
    if (move_uploaded_file($tempname, $folder)) {
      if (mysqli_query($conn, $sql)) {
        // Send registration email
        $toEmail = $email;
        $subject = 'Registration Successful';
        $body = 'Dear ' . $full_name . ',<br><br>Thank you for registering. Your registration was successful.<br><br>Best regards,<br>Tech CMS Team.';

        // Send the email and handle the result
        $result = send_registration_Email($toEmail, $subject, $body);

        if (!$result) {
          echo 'Email not sent.';
        } else {
          // If email sent, show success message and redirect to login page
          echo '<script>
            alert("Author Registered Successfully");
            window.location.href = "login.php";
          </script>';
        }
      } else {
        // If query failed, show an alert and redirect to login page
        echo '<script>alert("Oops!! Registration failed!!");
        window.location.href = "login.php";
        </script>';
      }
    } else {
      // If image upload failed, show an alert and redirect to login page
      echo '<script>alert("Failed to upload image!");
      window.location.href = "login.php";
      </script>';
    }
  }
}

// Login code
if (isset($_POST['login'])) {
  $email = $_POST['email'];
  $password = md5($_POST['password']); // Hash the password

  // Check if the user exists with the provided email and password
  $sql = "SELECT email, password FROM user WHERE email= '$email' AND password='$password' AND deleted_at = '0000-00-00 00:00:00'";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
    // If user exists, set session email and check user role
    $row = mysqli_fetch_assoc($result);
    $_SESSION['email'] = $row['email'];

    $author_admin = "SELECT role FROM user WHERE email = '{$_SESSION['email']}' AND deleted_at = '0000-00-00 00:00:00'";
    $author_admin_result = mysqli_query($conn, $author_admin);

    if (mysqli_num_rows($author_admin_result) > 0) {
      $user = mysqli_fetch_assoc($author_admin_result);

      if ($user['role'] != 'Admin') {
        // If user is an Author, show success message and redirect to index page
        echo '<script>
            alert("Author Login successful. Welcome ' . $_SESSION['email'] . '");
            window.location.href = "index.php";
        </script>';
      } else {
        // If user is an Admin, show success message and redirect to admin index page
        echo '<script>
          alert("Admin Login successful. Welcome ' . $_SESSION['email'] . '");
          window.location.href = "admin/index.php";
        </script>';
      }
    } else {
      // If user not found, show an alert and redirect to login page
      echo '<script>alert("User not found. Please register!!");
      window.location.href = "login.php";
      </script>';
    }
  } else {
    // If invalid email or password, show an alert and redirect to login page
    echo '<script>alert("Invalid email or password");
     window.location.href = "login.php";
     </script>';
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
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
          <!-- Login form -->
          <form action="" id="loginForm" method="post">
            <h2>Sign In</h2>
            <input type="email" name="email" id="email" placeholder="Email" />
            <input type="password" name="password" id="" placeholder="Password" />
            <input type="submit" name="login" value="Login" />
            <p class="signup">
              Don't have an account ?
              <a href="#" onclick="toggleForm();">Sign Up.</a></p>
              <p class="signup"><a class="ml-5 " href="forgot_email.php">Forgot password?</a></p>
          </form>
        </div>
      </div>
      <div class="user signupBx">
        <div class="formBx">
          <!-- Registration form -->
          <form action="" id="registerForm" method="post" enctype="multipart/form-data">
            <h2>Create an account</h2>
            <input type="text" name="full_name" id="full_name" placeholder="Fullname" />
            <input type="email" name="email" id="email" placeholder="Email Address" />
            <input type="password" name="password" id="password" placeholder="Create Password" />
            <input type="password" name="cpassword" id="cpassword" placeholder="Confirm Password" />
            <input type="file" name="profile" id="profile">
            <input type="submit" name="register" value="Sign Up" />
            <p class="signup">
              Already have an account ?
              <a href="#" onclick="toggleForm();">Sign in.</a>
            </p>
          </form>
        </div>
        <div class="imgBx"><img src="image/login.jpg" alt="" /></div>
      </div>
    </div>
  </section>
</body>

<script src="js/validation.js"></script>

</html>
