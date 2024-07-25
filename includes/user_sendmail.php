<?php
// Use PHPMailer for sending emails
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer files
require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

// Function to send registration email
function send_registration_Email($toEmail, $subject, $body, $fromEmail = 'agrawalanjali8743@gmail.com', $fromName = 'Anjali Agrawal') {
    $mail = new PHPMailer(true);
    
    try {
        // Server settings
        $mail->isSMTP(); // Set mailer to use SMTP
        $mail->Host       = 'smtp.gmail.com'; // Specify main and backup SMTP servers
        $mail->SMTPAuth   = true; // Enable SMTP authentication
        $mail->Username   = 'agrawalanjali8743@gmail.com'; // SMTP username
        $mail->Password   = 'lolzmsebmmlrutzq'; // SMTP password
        $mail->Port       = 587; // TCP port to connect to

        // Recipients
        $mail->setFrom($fromEmail, $fromName); // Set sender of the email
        $mail->addAddress($toEmail); // Add a recipient

        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = $subject; // Set email subject
        $mail->Body    = $body; // Set email body
        $mail->send(); // Send the email
        
        return true; // Return true if email is sent successfully
    } catch (Exception $e) {
        // Return error message if email could not be sent
        return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

// Function to send blog addition email notification to admin
function send_addblog_Email($subject, $body, $fromEmail, $fromName) {
    $mail = new PHPMailer(true);
    $adminEmail = 'agrawalanjali8743@gmail.com'; // Admin email address

    try {
        // Server settings
        $mail->isSMTP(); // Set mailer to use SMTP
        $mail->Host       = 'smtp.gmail.com'; // Specify main and backup SMTP servers
        $mail->SMTPAuth   = true; // Enable SMTP authentication
        $mail->Username   = 'agrawalanjali8743@gmail.com'; // SMTP username
        $mail->Password   = 'lolzmsebmmlrutzq'; // SMTP password
        $mail->Port       = 587; // TCP port to connect to

        // Recipients
        $mail->setFrom($fromEmail, $fromName); // Set sender of the email
        $mail->addAddress($adminEmail); // Add admin email as recipient

        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = $subject; // Set email subject
        $mail->Body    = $body; // Set email body
        $mail->send(); // Send the email
        
        return true; // Return true if email is sent successfully
    } catch (Exception $e) {
        // Return error message if email could not be sent
        return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
