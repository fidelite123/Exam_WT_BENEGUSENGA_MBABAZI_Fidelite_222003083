<?php
// Database connection
require_once 'db_connection.php';

// Initialize variables
$event_id = $volunteer_id = "";
$event_id_err = $volunteer_id_err = "";

// Get the event ID and volunteer ID from the URL
if (isset($_GET['event_id']) && isset($_GET['volunteer_id'])) {
    $event_id = $_GET['event_id'];
    $volunteer_id = $_GET['volunteer_id'];
    
    // Fetch the current details from the database
    $sql = "SELECT * FROM eventvolunteers WHERE event_id = ? AND volunteer_id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ii", $event_id, $volunteer_id);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $event_id = $row['event_id'];
                $volunteer_id = $row['volunteer_id'];
            } else {
                echo "Error fetching the current details.";
            }
        } else {
            echo "Error executing the query: " . $stmt->error;
        }
    } else {
        echo "Error preparing the query: " . $conn->error;
    }
}

// Update the details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_id = $_POST['event_id'];
    $volunteer_id = $_POST['volunteer_id'];
    
    // Validate inputs
    if (empty($event_id)) {
        $event_id_err = "Please enter the event ID.";
    }
    if (empty($volunteer_id)) {
        $volunteer_id_err = "Please enter the volunteer ID.";
    }
    
    // Check if there are no errors
    if (empty($event_id_err) && empty($volunteer_id_err)) {
        // Prepare the update query
        $sql = "UPDATE eventvolunteers SET event_id = ?, volunteer_id = ? WHERE event_id = ? AND volunteer_id = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("iiii", $event_id, $volunteer_id, $_GET['event_id'], $_GET['volunteer_id']);
            if ($stmt->execute()) {
                echo "Record updated successfully.";
                header("Location: eventvolunteers.php"); // Redirect to the event volunteers page after update
                exit();
            } else {
                echo "Error updating the record: " . $stmt->error;
            }
        } else {
            echo "Error preparing the update query: " . $conn->error;
        }
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Event Volunteer</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        body { font-family: Arial, sans-serif; background-color: darkgreen; color: white; }
        .container { margin: 0 auto; padding: 20px; width: 50%; background-color: black; border-radius: 10px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; }
        .form-group input { width: 100%; padding: 8px; box-sizing: border-box; }
        .form-group .error { color: red; }
        .form-group input[type="submit"] { background-color: green; color: white; border: none; cursor: pointer; }
        .form-group input[type="submit"]:hover { background-color: darkgreen; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Update Event Volunteer</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?event_id=" . $event_id . "&volunteer_id=" . $volunteer_id; ?>" method="post">
            <div class="form-group">
                <label for="event_id">Event ID</label>
                <input type="text" name="event_id" id="event_id" value="<?php echo htmlspecialchars($event_id); ?>">
                <span class="error"><?php echo $event_id_err; ?></span>
            </div>
            <div class="form-group">
                <label for="volunteer_id">Volunteer ID</label>
                <input type="text" name="volunteer_id" id="volunteer_id" value="<?php echo htmlspecialchars($volunteer_id); ?>">
                <span class="error"><?php echo $volunteer_id_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" value="Update">
            </div>
        </form>
    </div>
</body>
</html>
