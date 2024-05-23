<?php
// Database connection
require_once 'db_connection.php';

// Initialize the message variable
$message = "";

// Check if the report_id is set in the query string
if (isset($_GET['report_id'])) {
    $report_id = $_GET['report_id'];

    // Prepare the SQL delete statement
    $sql = "DELETE FROM reports WHERE report_id = ?";

    // Initialize prepared statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("i", $report_id);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Records deleted successfully
            $message = "Record deleted successfully.";
        } else {
            $message = "Error: Could not execute the delete statement. " . $conn->error;
        }
    } else {
        $message = "Error: Could not prepare the delete statement. " . $conn->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    $message = "Error: report_id parameter was not provided.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Delete Report</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: skyblue;
      text-align: center;
      padding: 50px;
    }
    .message {
      background-color: white;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      display: inline-block;
    }
  </style>
</head>
<body>
  <div class="message">
    <h2>Delete Report</h2>
    <p><?php echo $message; ?></p>
    <a href="reports.php">Back to Reports</a>
  </div>
</body>
</html>
