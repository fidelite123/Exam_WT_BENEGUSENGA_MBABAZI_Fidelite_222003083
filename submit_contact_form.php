<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form fields and remove whitespace
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $message = trim($_POST["message"]);

    // Set the recipient email address
    $to = "benegusengambabazifidelite@gmail.com"; // Replace with your own email address

    // Set the email subject
    $subject = "New Contact Form Submission";

    // Build the email content
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Message:\n$message\n";

    // Build the email headers
    $headers = "From: $name <$email>";

    // Send the email
    if (mail($to, $subject, $email_content, $headers)) {
        // Email sent successfully
        echo "Thank you! Your message has been sent.";
    } else {
        // Failed to send email
        echo "Oops! Something went wrong. Please try again later.";
    }
} else {
    // Not a POST request, so redirect to the contact page
    header("Location: contact.html");
}
?>
