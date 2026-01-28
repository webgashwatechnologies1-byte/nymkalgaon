<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitize inputs
    $name    = htmlspecialchars(trim($_POST['name']));
    $email   = htmlspecialchars(trim($_POST['email']));
    $phone   = htmlspecialchars(trim($_POST['phone']));
    $role    = htmlspecialchars(trim($_POST['role']));
    $message = htmlspecialchars(trim($_POST['message'] ?? 'N/A'));

    // Receiver email
    $to = "info@nymkalgaon.com";

    // Subject
    $subject = "New Registration - Snowfall Cup";

    // Email body
    $body = "
    New Registration Received

    Name: $name
    Email: $email
    Phone: $phone
    Role: $role
    Message: $message
    ";

    // Headers
    $headers = "From: Snowfall Cup <info@nymkalgaon.com>\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Send mail
    if (mail($to, $subject, $body, $headers)) {
        header("Location: thanks.php");
        exit;
    } else {
        echo "Mail sending failed.";
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}
