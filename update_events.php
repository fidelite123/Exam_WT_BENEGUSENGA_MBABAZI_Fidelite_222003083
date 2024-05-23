<?php
// Database connection
require_once 'db_connection.php';

// Initialize variables
$name = $date = $location = $description = $goal = $campaign_id = "";
$message = "";

// Check if the report_id is set in the query string
if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];

    // Fetch the current data for the report
    $sql = "SELECT * FROM events WHERE event_id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            // Fetch the report data
            $row = $result->fetch_assoc();
            $name = $row['name'];
            $date = $row['date'];
            $location = $row['location'];
            $description = $row['description'];
            $goal = $row['goal'];
            $campaign_id = $row['campaign_id'];
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
        $event_id = $_POST['event_id'];
        $name = $_POST['name'];
        $date = $_POST['date'];
        $location = $_POST['location'];
        $description = $_POST['description'];
 $goal = $_POST['goal'];
 $campaign_id = $_POST['campaign_id'];
        // Prepare the SQL update statement
        $sql = "UPDATE events SET name = ?, date = ?, location= ?, description= ?, goal= ?, campaign_id = ? WHERE event_id = ?";
        
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sssssii", $name, $date, $location, $description, $goal, $campaign_id,  $event_id);
            
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
    <h2>Update events</h2>
    <p><?php echo $message; ?></p>
    <form method="post">

        
      <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
      <label for="name">name:</label>
      <input type="text" id="name" name="name" value="<?php echo $name; ?>" required><br>

 <label for="date">date:</label>
      <input type="date" id="date" name="date" value="<?php echo $date; ?>" required><br>

      <label for="location">location:</label>
      <input type="text" id="location" name="location" value="<?php echo $location; ?>" required><br>

      <label for="description">description:</label>
      <input type="text" id="description" name="description" value="<?php echo $description; ?>" required><br>

        <label for="goal">goal:</label>
      <input type="text" id="goal" name="goal" value="<?php echo $goal; ?>" required><br>


      <label for="campaign_id">campaign_id:</label>
      <input type="number" id="campaign_id" name="campaign_id" value="<?php echo $campaign_id; ?>" required><br>

      <input type="submit" name="update" value="Update">
    </form>
    <a href="events.php">Back to events</a>
  </div>
</body>
</html>
