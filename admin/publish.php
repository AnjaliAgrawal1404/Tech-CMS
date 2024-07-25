<?php
// Include database configuration and mail sending functions
include 'includes/db_config.php';
include 'includes/admin_sendmail.php';

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: .././login.php");
    exit();
} else {
    // Check if both postId and status are set in the POST request
    if (isset($_POST['postId']) && isset($_POST['status'])) {
        $postId = $_POST['postId']; // Get the post ID
        $status = $_POST['status']; // Get the status

        // SQL query to update the published status of the blog post
        $result = "UPDATE blog SET published_status = '$status' WHERE blog_id = '$postId'";
        $row = mysqli_query($conn, $result);

        // Check if the update was successful
        if ($row) {
            // Retrieve the updated blog post details
            $sql = "SELECT * FROM blog WHERE blog_id='$postId'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_array($result);

                // Retrieve the author's details
                $get_user_name = "SELECT full_name, email FROM user WHERE user_id= '{$row['user_id']}'";
                $result = mysqli_query($conn, $get_user_name);
                $name = mysqli_fetch_assoc($result);
            }

            $email = $name['email']; // Author's email
            $author_name = $name['full_name']; // Author's name
            $title = $row['blog_title']; // Blog post title

            $toEmail = $email; // Recipient's email
            $subject = 'Your Blog Post Has Been Published!'; // Email subject
            $body = "
            <h1>Congratulations!</h1>
            <p>Your blog post titled <strong>$title</strong> has been published successfully.</p>
            <p><strong>Post ID:</strong> $postId</p>
            <p><strong>Author:</strong> $author_name</p>
            <p>Thank you for contributing to our blog. You can view your published post on our website.</p>
            <p>Best regards,<br>Tech CMS.</p>
        ";

            // Send the email
            $result = send_published_email($toEmail, $subject, $body);

            // Handle the result of the email sending
            if (!$result) {
                echo 'Email not sent.';
            } else {
                echo "Publish status updated successfully";
            }
        } else {
            // Output error if the update failed
            echo "Error updating publish status: " . mysqli_error($conn);
        }
    } else {
        // Output error if postId or status is missing
        echo 'Error: postId or status is missing';
    }
}
?>
