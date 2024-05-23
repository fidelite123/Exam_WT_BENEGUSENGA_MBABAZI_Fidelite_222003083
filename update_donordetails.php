<?php
// Database connection
require_once 'db_connection.php';

// Initialize variables
$name = $contact_info = $preferred_causes = "";
$message = "";

// Check if the report_id is set in the query string
if (isset($_GET['donor_id'])) {
    $donor_id = $_GET['donor_id'];

    // Fetch the current data for the report
    $sql = "SELECT * FROM donordetails WHERE donor_id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $donor_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            // Fetch the report data
            $row = $result->fetch_assoc();
            $name = $row['name'];
            $contact_info = $row['contact_info'];
            $preferred_causes = $row['preferred_causes'];
        } else {
            $message = "Error: No record found with the provided donordetails ID.";
        }
        
        $stmt->close();
    } else {
        $message = "Error: Could not prepare the select statement. " . $conn->error;
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update'])) {
        $donor_id = $_POST['donor_id'];
        $name = $_POST['name'];
        $contact_info = $_POST['contact_info'];
        $preferred_causes = $_POST['preferred_causes'];
        
        // Prepare the SQL update statement
        $sql = "UPDATE donordetails SET name = ?, contact_info = ?, preferred_causes= ? WHERE donor_id = ?";
        
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sssi", $name, $contact_info, $preferred_causes,$donor_id);
            
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
  <title>Update DonorDetails</title>
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
    <h2>Update donordetails</h2>
    <p><?php echo $message; ?></p>
    <form method="post">

        
      <input type="hidden" name="donor_id" value="<?php echo $donor_id; ?>">
      <label for="name">name:</label>
      <input type="text" id="name" name="name" value="<?php echo $name; ?>" required><br>



      <label for="contact_info">contact_info:</label>
      <input type="text" id="contact_info" name="contact_info" value="<?php echo $contact_info; ?>" required><br>

      <label for="preferred_causes">preferred_causes:</label>
      <input type="text" id="preferred_causes" name="preferred_causes" value="<?php echo $preferred_causes; ?>" required><br>

        

      <input type="submit" name="update" value="Update">
    </form>
    <a href="donorDetails.php">Back to donordetails form</a>
  </div>
</body>
</html>
