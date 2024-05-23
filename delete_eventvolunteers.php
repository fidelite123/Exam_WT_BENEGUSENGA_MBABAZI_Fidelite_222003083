<?php
require_once 'db_connection.php';

if (isset($_GET['event_id']) && isset($_GET['volunteer_id'])) {
  $event_id = $_GET['event_id'];
  $volunteer_id = $_GET['volunteer_id'];

  $sql = "DELETE FROM eventvolunteers WHERE event_id='$event_id' AND volunteer_id='$volunteer_id'";

  if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully";
  } else {
    echo "Error: " . $conn->error;
  }

  $conn->close();
  header("Location: eventvolunteers.php");
  exit();
}
?>
