<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form fields and remove whitespace
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $amount = trim($_POST["amount"]);
    $currency = trim($_POST["currency"]);
    $message = trim($_POST["message"]);

    // Validate input
    if (empty($name) || empty($email) || empty($amount) || empty($currency)) {
        // Redirect back to the donation form with an error message
        header("Location: donate.html?error=empty_fields");
        exit();
    }

    // Additional validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Redirect back to the donation form with an error message
        header("Location: donate.html?error=invalid_email");
        exit();
    }

    if (!is_numeric($amount) || $amount <= 0) {
        // Redirect back to the donation form with an error message
        header("Location: donate.html?error=invalid_amount");
        exit();
    }

    // Process the donation (e.g., store in database, send email confirmation, etc.)
    // In this example, let's just log the donation details
    $log_message = "Donation Details:\n";
    $log_message .= "Name: $name\n";
    $log_message .= "Email: $email\n";
    $log_message .= "Amount: $amount $currency\n";
    $log_message .= "Message: $message\n";

    // Log the donation details to a file (you can replace this with your preferred method of storage)
    file_put_contents("donation_log.txt", $log_message, FILE_APPEND | LOCK_EX);

    // Redirect back to the donation form with a success message
    header("Location: donate.html?success=true");
    exit();
} else {
    // Not a POST request, so redirect to the donation form
    header("Location: donate.html");
    exit();
}
?>
