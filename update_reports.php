<?php
// Database connection
require_once 'db_connection.php';

// Initialize variables
$report_type = $related_campaigns = $related_donors = $user_id = "";
$message = "";

// Check if the report_id is set in the query string
if (isset($_GET['id'])) {
    $report_id = $_GET['id'];

    // Fetch the current data for the report
    $sql = "SELECT * FROM reports WHERE report_id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $report_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            // Fetch the report data
            $row = $result->fetch_assoc();
            $report_type = $row['report_type'];
            $related_campaigns = $row['related_campaigns'];
            $related_donors = $row['related_donors'];
            $user_id = $row['user_id'];
        } else {
            $message = "Error: No record found with the provided report ID.";
        }
        
        $stmt->close();
    } else {
        $message = "Error: Could not prepare the select statement. " . $conn->error;
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update'])) {
        $report_id = $_POST['report_id'];
        $report_type = $_POST['report_type'];
        $related_campaigns = $_POST['related_campaigns'];
        $related_donors = $_POST['related_donors'];
        $user_id = $_POST['user_id'];

        // Prepare the SQL update statement
        $sql = "UPDATE reports SET report_type = ?, related_campaigns = ?, related_donors = ?, user_id = ? WHERE report_id = ?";
        
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sssii", $report_type, $related_campaigns, $related_donors, $user_id, $report_id);
            
            if ($stmt->execute()) {
                $message = "Record updated successfully.";
            } else {
                $message = "Error: Could not execute the update statement. " . $conn->error;
            }
            
            $stmt->close();
        } else {
            $message = "Error: Could not prepare the update statement. " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Update Report</title>
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
    <h2>Update Report</h2>
    <p><?php echo $message; ?></p>
    <form method="post">
      <input type="hidden" name="report_id" value="<?php echo $report_id; ?>">
      <label for="report_type">Report Type:</label>
      <input type="text" id="report_type" name="report_type" value="<?php echo $report_type; ?>" required><br>

      <label for="related_campaigns">Related Campaigns:</label>
      <input type="text" id="related_campaigns" name="related_campaigns" value="<?php echo $related_campaigns; ?>" required><br>

      <label for="related_donors">Related Donors:</label>
      <input type="text" id="related_donors" name="related_donors" value="<?php echo $related_donors; ?>" required><br>

      <label for="user_id">User ID:</label>
      <input type="text" id="user_id" name="user_id" value="<?php echo $user_id; ?>" required><br>

      <input type="submit" name="update" value="Update">
    </form>
    <a href="reports.php">Back to Reports</a>
  </div>
</body>
</html>
