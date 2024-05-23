<?php
// Database connection
require_once 'db_connection.php';

// Initialize variables
$user_id = $campaign_id = $total_amount_raised = "";
$message = "";

// Check if the report_id is set in the query string
if (isset($_GET['fundraiser_id'])) {
    $fundraiser_id = $_GET['fundraiser_id'];

    // Fetch the current data for the report
    $sql = "SELECT * FROM fundraisers WHERE fundraiser_id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $fundraiser_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            // Fetch the report data
            $row = $result->fetch_assoc();
            $user_id = $row['user_id'];
            $campaign_id = $row['campaign_id'];
            $total_amount_raised = $row['total_amount_raised'];
        } else {
            $message = "Error: No record found with the provided fundraisers ID.";
        }
        
        $stmt->close();
    } else {
        $message = "Error: Could not prepare the select statement. " . $conn->error;
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update'])) {
        $fundraiser_id = $_POST['fundraiser_id'];
        $user_id = $_POST['user_id'];
        $campaign_id = $_POST['campaign_id'];
        $total_amount_raised = $_POST['total_amount_raised'];
        
        // Prepare the SQL update statement
        $sql = "UPDATE fundraisers SET user_id = ?, campaign_id = ?, total_amount_raised= ? WHERE fundraiser_id = ?";
        
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("iiii", $user_id, $campaign_id, $total_amount_raised, $fundraiser_id);
            
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
  <title>Update Fundraisers</title>
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
    <h2>Update fundraisers</h2>
    <p><?php echo $message; ?></p>
    <form method="post">

        
      <input type="hidden" name="fundraiser_id" value="<?php echo $fundraiser_id; ?>">
      <label for="user_id">user_id:</label>
      <input type="number" id="user_id" name="user_id" value="<?php echo $user_id; ?>" required><br>



      <label for="campaign_id">campaign_id:</label>
      <input type="number" id="campaign_id" name="campaign_id" value="<?php echo $contact_info; ?>" required><br>

      <label for="total_amount_raised">total_amount_raised:</label>
      <input type="number" id="total_amount_raised" name="total_amount_raised" value="<?php echo $total_amount_raised; ?>" required><br>

        

      <input type="submit" name="update" value="Update">
    </form>
    <a href="fundraisers.php">Back to fundraisers form</a>
  </div>
</body>
</html>
