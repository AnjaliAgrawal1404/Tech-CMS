<?php
include 'includes/db_config.php';
include 'includes/admin_sendmail.php';


if (!isset($_SESSION['email'])) {
    header("Location: .././login.php ");
    exit();
} else {
    // Check if postId and status are set and not empty
    if (isset($_POST['postId']) && isset($_POST['status'])) {
        $postId = $_POST['postId'];
        $status = $_POST['status'];
        echo ($_POST['status']);

        $result = "UPDATE blog SET published_status = '$status' WHERE blog_id = '$postId'";
        $row = mysqli_query($conn, $result);


        // Execute statement
        if ($row) {
        //     $sql = "select * from blog where blog_id='$postId'";
        //     $result = mysqli_query($conn, $sql);
        //     if (mysqli_num_rows($result) > 0) {
        //         $row = mysqli_fetch_array($result);

        //         $get_user_name = "select full_name,email from user where user_id= '{$row['user_id']}'";
        //         $result = mysqli_query($conn, $get_user_name);
        //         $name = mysqli_fetch_assoc($result);
        //     }

        //     $email = $_name['email'];
        //     $author_name = $_name['full_name'];
        //     $title = $row['blog_title'];

        //     $toEmail = $email;
        //     $subject = 'Your Blog Post Has Been Published!';
        //     $body = "
        //     <h1>Congratulations!</h1>
        //     <p>Your blog post titled <strong>$title</strong> has been published successfully.</p>
        //     <p><strong>Post ID:</strong> $postId</p>
        //     <p><strong>Author:</strong> $author_name</p>
        //     <p>Thank you for contributing to our blog. You can view your published post on our website.</p>
        //     <p>Best regards,<br>Tech CMS.</p>
        // ";

        //     // Send the email
        //     $result = send_published_email($toEmail, $subject, $body);

        //     // Handle the result
        //     if (!$result) {
        //         echo 'Email not sent.';
        //     } else {
                echo "Publish status updated successfully";
          //  }
        } else {
            echo "Error updating publish status: " . mysqli_error($conn);
        }
    } else {
        // Echo error message if postId or status is not set
        echo 'Error: postId or status is missing';
    }
}
