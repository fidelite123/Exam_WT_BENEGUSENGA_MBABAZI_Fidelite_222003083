<?php
// Establish Database Connection
require_once 'db_connection.php';

// Handle Form Submission for Login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['user_name'];
    $password = $_POST['password'];

    // Prepare SQL statement to retrieve user information
    $sql = "SELECT user_id, user_name, password FROM users WHERE user_name=?";

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    // Bind the username parameter to the prepared statement
    $stmt->bind_param("s", $username);

    // Execute the prepared statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if a row was returned
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Verify the password using password_verify
        if (password_verify($password, $row['password'])) {
            // Set session variable and redirect upon successful login
            session_start();
            $_SESSION['user_id'] = $row['user_id'];
            header("Location: home.html");
            exit();
        } else {
            echo "Invalid username or password";
        }
    } else {
        echo "User not found";
    }

    // Close prepared statement
    $stmt->close();
}

// Close database connection
$conn->close();
?>
