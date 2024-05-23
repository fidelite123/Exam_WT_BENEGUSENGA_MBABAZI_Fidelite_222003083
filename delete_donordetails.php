<?php
include('db_Connection.php');


if(isset($_REQUEST['donor_id'])) {
    $eid = $_REQUEST['donor_id'];
    
    // Prepare and execute the DELETE statement
    $stmt = $conn->prepare("DELETE FROM donordetails WHERE donor_id=?");
    $stmt->bind_param("i", $eid);
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
            <input type="hidden" name="donor_id" value="<?php echo $eid; ?>">
            <input type="submit" value="Delete">
        </form>

        <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($stmt->execute()) {
        echo "Record deleted successfully.<br><br>
             <a href='donordetails.php'>return on the donordetails form</a>";
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
    echo "donordetails ID is not set.";
}

$conn->close();
?>