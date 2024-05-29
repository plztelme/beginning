<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
require_once __DIR__ . '/vendor/autoload.php';
$email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) : null;
$email = $email ? filter_var($email, FILTER_SANITIZE_EMAIL) : null;

// Validate and sanitize subject
$subject = isset($_POST['subject']) ? filter_var($_POST['subject'], FILTER_SANITIZE_STRING) : null;

// Validate and sanitize message
$message = isset($_POST['message']) ? filter_var($_POST['message'], FILTER_SANITIZE_STRING) : null;

// Check if all required fields are provided and valid
if ($email && $subject && $message) {
    // Proceed with sending the email
    smtp_mailer($email, $subject, $message);
} else {
    // Handle missing or invalid input
    echo "Invalid input data.";
}

function smtp_mailer($to, $from, $subject, $msg) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
        $mail->Username   = 'mrdroider390@gmail.com';
        $mail->Password   = 'dvjt mikr udlx ngsl';
        $mail->Port       = 587;

        // Sender and recipient settings
        $mail->setFrom('mrdroider390@gmail.com', 'mrdroider');
        $mail->addReplyTo($from);
        $mail->addAddress($to);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $msg;
        $mail->AltBody = strip_tags($msg);

        $mail->send();
        return 'Message has been sent';
    } catch (Exception $e) {
        return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

echo smtp_mailer('mrdroider390@gmail.com', $email, $subject, "<b>{$email}, {$message}</b>");
?>