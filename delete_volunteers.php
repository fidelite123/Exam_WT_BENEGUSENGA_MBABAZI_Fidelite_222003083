<?php
include('db_Connection.php');


if(isset($_REQUEST['volunteer_id'])) {
    $vid = $_REQUEST['volunteer_id'];
    
    // Prepare and execute the DELETE statement
    $stmt = $conn->prepare("DELETE FROM volunteers WHERE volunteer_id=?");
    $stmt->bind_param("i", $vid);
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Delete Record</title>
        <script>
            function confirmDelete() {
                return confirm("Are you sure you want to delete this record?");
            }
        </script>
    </head>
    <body>
        <form method="post" onsubmit="return confirmDelete();">
            <input type="hidden" name="volunteer_id" value="<?php echo $vid; ?>">
            <input type="submit" value="Delete">
        </form>

        <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($stmt->execute()) {
        echo "Record deleted successfully.<br><br>
             <a href='volunteers.php'>return on the form</a>";
    } else {
        echo "Error deleting data: " . $stmt->error;
    }
}
?>
    </body>
    </html>
    <?php
    $stmt->close();
} else {
    echo "volunteer ID is not set.";
}

$conn->close();
?>