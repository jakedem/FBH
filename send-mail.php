<?php
// Include PHPMailer classes in your script
require 'pmailer/src/Exception.php';
require 'pmailer/src/PHPMailer.php';
require 'pmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $to = filter_var($_POST['to'], FILTER_SANITIZE_EMAIL);
  $subject = htmlspecialchars($_POST['subject']);
  $message = htmlspecialchars($_POST['message']);

  if (filter_var($to, FILTER_VALIDATE_EMAIL)) {
    $mail = new PHPMailer(true);
    try {
      // Server settings
      $mail->isSMTP(); // Set mailer to use SMTP
      $mail->Host       = 'smtp.gmail.com'; // Specify main and backup SMTP servers
      $mail->SMTPAuth   = true; // Enable SMTP authentication
      $mail->Username   = 'jerryanane13@gmail.com'; // Your Gmail address
      $mail->Password   = 'jjrd jxkb punv yhrv'; // Your Gmail password or app-specific password
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption, `ssl` also accepted
      $mail->Port       = 587; // TCP port to connect to

      // Recipients
      $mail->setFrom('jerryanane13@gmail.com', 'Jerry Anane');
      $mail->addAddress($to); // Add a recipient

      // Content
      $mail->isHTML(true); // Set email format to HTML
      $mail->Subject = $subject;
      $mail->Body    = $message;
      $mail->AltBody = strip_tags($message); // Plain text version for non-HTML mail clients

      $mail->send();
      echo "Email sent successfully!";
    } catch (Exception $e) {
      echo "Failed to send email. Error: {$mail->ErrorInfo}";
    }
  } else {
    echo "Invalid email address.";
  }
} else {
  echo "Invalid request method.";
}
