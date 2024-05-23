<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate password and confirm password
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        echo "Passwords do not match.";
    } else {
        // Hash the new password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Save the new password to the database or update the user's record
        // Replace this with your database logic
         Example: $sql = "UPDATE users SET password='$hashed_password' WHERE email='$user_email'";
        
        // Redirect to a success page
        header("Location: reset_password_success.html");
        exit();
    }
}
?>