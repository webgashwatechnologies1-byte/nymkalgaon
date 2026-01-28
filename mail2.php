<?php
// Show errors during testing (turn OFF after live)
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Sanitize inputs
    $name    = htmlspecialchars(trim($_POST['name']));
    $email   = htmlspecialchars(trim($_POST['email']));
    $phone   = htmlspecialchars(trim($_POST['phone']));
    $city    = htmlspecialchars(trim($_POST['city']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Receiver email
    $to = "info@yourdomain.com"; // CHANGE THIS

    // Subject
    $subject = "New Contact Form Submission";

    // Email body
    $body = "
        You have received a new enquiry:

        Name: $name
        Email: $email
        Phone: $phone
        City: $city

        Message:
        $message
        ";

    // Headers
    $headers  = "From: Website Enquiry <info@yourdomain.com>\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Send mail
    if (mail($to, $subject, $body, $headers)) {
        header("Location: thanks.php");
        exit;
    } else {
        echo "Error: Mail could not be sent.";
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}
