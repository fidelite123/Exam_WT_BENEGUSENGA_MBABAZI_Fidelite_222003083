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
$name = $goal_amount = $description = $start_date = $end_date = $current_amount_raised = $status = $charity_id = "";
$message = "";

// Check if the campaign_id is set in the query string
if (isset($_GET['campaign_id'])) {
    $campaign_id = $_GET['campaign_id'];

    // Fetch the current data for the campaign
    $sql = "SELECT * FROM campaigns WHERE campaign_id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $campaign_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            // Fetch the campaign data
            $row = $result->fetch_assoc();
            $name = $row['name'];
            $goal_amount = $row['goal_amount'];
            $description = $row['description'];
            $start_date = $row['start_date'];
            $end_date = $row['end_date'];
            $current_amount_raised = $row['current_amount_raised'];
            $status = $row['status'];
            $charity_id = $row['charity_id'];
        } else {
            $message = "Error: No record found with the provided campaign ID.";
        }
        
        $stmt->close();
    } else {
        $message = "Error: Could not prepare the select statement. " . $conn->error;
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update'])) {
        $campaign_id = $_POST['campaign_id'];
        $name = $_POST['name'];
        $goal_amount = $_POST['goal_amount'];
        $description = $_POST['description'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $current_amount_raised = $_POST['current_amount_raised'];
        $status = $_POST['status'];
        $charity_id = $_POST['charity_id'];

        // Prepare the SQL update statement
        $sql = "UPDATE campaigns SET name = ?, goal_amount = ?, description = ?, start_date = ?, end_date = ?, current_amount_raised = ?, status = ?, charity_id = ? WHERE campaign_id = ?";
        
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sisssisii", $name, $goal_amount, $description, $start_date, $end_date, $current_amount_raised, $status, $charity_id, $campaign_id);
            
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
  <title>Update Campaign</title>
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
    <h2>Update Campaign</h2>
    <p><?php echo $message; ?></p>
    <form method="post">
      <input type="hidden" name="campaign_id" value="<?php echo $campaign_id; ?>">
      <label for="name">Name:</label>
      <input type="text" id="name" name="name" value="<?php echo $name; ?>" required><br>
      <label for="goal_amount">Goal Amount:</label>
      <input type="number" id="goal_amount" name="goal_amount" value="<?php echo $goal_amount; ?>" required><br>
      <label for="description">Description:</label>
      <input type="text" id="description" name="description" value="<?php echo $description; ?>" required><br>
      <label for="start_date">Start Date:</label>
      <input type="date" id="start_date" name="start_date" value="<?php echo $start_date; ?>" required><br>
      <label for="end_date">End Date:</label>
      <input type="date" id="end_date" name="end_date" value="<?php echo $end_date; ?>" required><br>
      <label for="current_amount_raised">Current Amount Raised:</label>
      <input type="number" id="current_amount_raised" name="current_amount_raised" value="<?php echo $current_amount_raised; ?>" required><br>
      <label style="font-weight: bold;">status</label>
            <select name="status">
                <option>draft</option>
                <option selected>active</option>
                <option>paused</option>
                <option>completed</option>
                <option>cancelled</option>
            </select><br><br>
      <label for="charity_id">Charity ID:</label>
      <input type="number" id="charity_id" name="charity_id" value="<?php echo $charity_id; ?>" required><br>
      <input type="submit" name="update" value="Update">
    </form>
    <a href="campaign.php">Back to campaigns</a>
  </div>
</body>
</html>
