<?php
require_once 'db_connection.php';

// Check if volunteer_id is set and retrieve volunteer details
if (isset($_GET['id'])) {
    $volunteer_id = $_GET['id'];
    
    $stmt = $conn->prepare("SELECT * FROM volunteers WHERE volunteer_id = ?");
    $stmt->bind_param("i", $volunteer_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $contact_info = $row['contact_info'];
        $skills = $row['skills'];
        $availability = $row['availability'];
        $assigned_tasks = $row['assigned_tasks'];
    } else {
        echo "Volunteer not found.";
        exit();
    }
} else {
    echo "No volunteer ID provided.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve updated values from form
    $name = $_POST['name'];
    $contact_info = $_POST['contact_info'];
    $skills = $_POST['skills'];
    $availability = $_POST['availability'];
    $assigned_tasks = $_POST['assigned_tasks'];

    // Update the volunteer in the database
    $stmt = $conn->prepare("UPDATE volunteers SET name = ?, contact_info = ?, skills = ?, availability = ?, assigned_tasks = ? WHERE volunteer_id = ?");
    $stmt->bind_param("sssssi", $name, $contact_info, $skills, $availability, $assigned_tasks, $volunteer_id);
    if ($stmt->execute()) {
        echo "Volunteer updated successfully! <br><br>
             <a href='Volunteers.php'>return to volunteer form</a>";
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Volunteer</title>
    <style>
        body {
            background-color: skyblue;
        }
        form {
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            width: 300px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label, input {
            display: block;
            margin-bottom: 10px;
        }
        input[type="submit"] {
            margin-top: 20px;
        }
    </style>
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required><br>

        <label for="contact_info">Contact Info:</label>
        <input type="text" id="contact_info" name="contact_info" value="<?php echo htmlspecialchars($contact_info); ?>" required><br>

        <label for="skills">Skills:</label>
        <input type="text" id="skills" name="skills" value="<?php echo htmlspecialchars($skills); ?>" required><br>

        <label for="availability">Availability:</label>
        <input type="text" id="availability" name="availability" value="<?php echo htmlspecialchars($availability); ?>" required><br>

        <label for="assigned_tasks">Assigned Tasks:</label>
        <input type="text" id="assigned_tasks" name="assigned_tasks" value="<?php echo htmlspecialchars($assigned_tasks); ?>" required><br>

        <input type="submit" value="Update">
    </form>
</body>
</html>
