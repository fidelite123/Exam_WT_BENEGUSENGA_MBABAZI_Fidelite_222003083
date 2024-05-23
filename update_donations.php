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
$amount = $date = $payment_method = $campaign_id = $donor_id = "";
$message = "";


if (isset($_GET['donation_id'])) {
    $donation_id = $_GET['donation_id'];

    // Fetch the current data for the donation
    $sql = "SELECT * FROM donations WHERE donation_id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $donation_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            
            $row = $result->fetch_assoc();
            $amount = $row['amount'];
            $date = $row['date'];
            $payment_method = $row['payment_method'];
            $campaign_id = $row['campaign_id'];
            $donor_id = $row['donor_id'];
            
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
        $donation_id = $_POST['donation_id'];
        $amount = $_POST['amount'];
        $date = $_POST['date'];
        $payment_method= $_POST['payment_method'];
        $campaign_id = $_POST['campaign_id'];
        $donor_id = $_POST['donor_id'];
       

        // Prepare the SQL update statement
        $sql = "UPDATE donations SET amount = ?, date = ?, payment_method = ?, campaign_id = ?, donor_id = ? WHERE donation_id = ?";
        
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("issiii", $amount, $date, $payment_method, $campaign_id, $donor_id, $donation_id);
            
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
  <title>Update donations</title>
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
    <h2>Update Donations</h2>
    <p><?php echo $message; ?></p>
    <form method="post">
       
      <input type="hidden" name="donation_id" value="<?php echo $donation_id; ?>">
      <label for="amount">amount:</label>
      <input type="number" id="amount" name="amount" value="<?php echo $amount; ?>" required><br>
      <label for="date">date:</label>
      <input type="date" id="date" name="date" value="<?php echo $date; ?>" required><br>
      <label for="payment_method">payment_method:</label>
      <input type="text" id="payment_method" name="payment_method" value="<?php echo $payment_method; ?>" required><br>
      <label for="campaign_id">campaign_id</label>
      <input type="number" id="campaign_id" name="campaign_id" value="<?php echo $campaign_id; ?>" required><br>
      <label for="donor_id">donor_id:</label>
      <input type="number" id="donor_id" name="donor_id" value="<?php echo $donor_id; ?>" required><br>
      
      
      <input type="submit" name="update" value="Update">
    </form>
    <a href="donations.php">Back to donations</a>
  </div>
</body>
</html>
