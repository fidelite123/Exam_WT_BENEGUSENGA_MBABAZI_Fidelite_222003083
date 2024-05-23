<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $user_name = $_POST['user_name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone_number = $_POST['phone_number'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $errors = [];

    // Validate form data
    if (empty($user_name) || empty($email) || empty($address) || empty($phone_number) || empty($password) || empty($role)) {
        $errors[] = "All fields are required.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }

    if (empty($errors)) {
        // Database connection parameters
        require_once 'db_connection.php';
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if email already exists
        $stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            echo "<div class='error-message'>Email already registered. Please use a different email.</div>";
        } else {
            // Hash the password before saving to the database
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert new user
            $stmt = $conn->prepare("INSERT INTO users (user_name, email, address, phone_number, password, role) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $user_name, $email, $address, $phone_number, $hashed_password, $role);
            
            if ($stmt->execute()) {
                // Redirect to login page after successful registration
                header("Location: login.html");
                exit(); // Ensure that no more code is executed after redirection
            } else {
                echo "<div class='error-message'>Error: " . $stmt->error . "</div>";
            }
        }

        // Close statement and connection
        $stmt->close();
        $conn->close();
    } else {
        echo "<div class='error-message'>" . implode("<br>", $errors) . "</div>";
    }
}
?>
