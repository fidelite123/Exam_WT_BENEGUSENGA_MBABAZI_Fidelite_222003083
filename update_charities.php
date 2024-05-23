<?php
// Enable error reporting for debugging purposes
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Ensure no output before headers
ob_start();

// Start session at the beginning of the script
session_start();

// Establish Database Connection
require_once 'db_connection.php';

// Initialize variables
$name = $registration_details = $contact_info = $mission_statement = "";
$message = "";

// Check if the charity_id is set in the query string
if (isset($_GET['charity_id'])) {
    $charity_id = $_GET['charity_id'];

    // Fetch the current data for the charity
    $sql = "SELECT * FROM charities WHERE charity_id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $charity_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            // Fetch the charity data
            $row = $result->fetch_assoc();
            $name = $row['name'];
            $registration_details = $row['registration_details'];
            $contact_info = $row['contact_info'];
            $mission_statement = $row['mission_statement'];
        } else {
            $message = "Error: No record found with the provided charity ID.";
        }

        $stmt->close();
    } else {
        $message = "Error: Could not prepare the select statement. " . $conn->error;
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update'])) {
        $charity_id = $_POST['charity_id'];
        $name = $_POST['name'];
        $registration_details = $_POST['registration_details'];
        $contact_info = $_POST['contact_info'];
        $mission_statement = $_POST['mission_statement'];

        // Prepare the SQL update statement
        $sql = "UPDATE charities SET name = ?, registration_details = ?, contact_info = ?, mission_statement = ? WHERE charity_id = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssssi", $name, $registration_details, $contact_info, $mission_statement, $charity_id);

            if ($stmt->execute()) {
                $message = "Record updated successfully.";
            } else {
                $message = "Error: Could not execute the update statement. " . $stmt->error;
            }

            $stmt->close();
        } else {
            $message = "Error: Could not prepare the update statement. " . $conn->error;
        }
    }
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Update Charity</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: skyblue;
      text-align: center;
      padding: 50px;
    }
    .form-container {
      background-color: white;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      display: inline-block;
      text-align: left;
    }
    .form-container input {
      margin-bottom: 10px;
      padding: 8px;
      width: 100%;
    }
    .form-container input[type="submit"] {
      width: auto;
      background-color: darkslategray;
      color: white;
      border: none;
      cursor: pointer;
    }
    .form-container input[type="submit"]:hover {
      background-color: #555;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h2>Update Charity</h2>
    <p><?php echo $message; ?></p>
    <form method="post">
      <input type="hidden" name="charity_id" value="<?php echo $charity_id; ?>">
      <label for="name">Name:</label>
      <input type="text" id="name" name="name" value="<?php echo $name; ?>" required><br>
      <label for="registration_details">Registration Details:</label>
      <input type="text" id="registration_details" name="registration_details" value="<?php echo $registration_details; ?>" required><br>
      <label for="contact_info">Contact Info:</label>
      <input type="text" id="contact_info" name="contact_info" value="<?php echo $contact_info; ?>" required><br>
      <label for="mission_statement">Mission Statement:</label>
      <input type="text" id="mission_statement" name="mission_statement" value="<?php echo $mission_statement; ?>" required><br>
      <input type="submit" name="update" value="Update">
    </form>
    <a href="charities.php">Back to charities</a>
  </div>
</body>
</html>
