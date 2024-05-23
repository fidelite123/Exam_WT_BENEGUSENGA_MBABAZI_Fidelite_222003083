<?php
include('db_Connection.php');

if(isset($_GET['fundraiser_id'])) {
    $eid = $_GET['fundraiser_id'];

    // Prepare the SQL statement outside the HTML block
    $stmt = $conn->prepare("DELETE FROM fundraisers WHERE fundraiser_id=?");
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
            <input type="hidden" name="fundraiser_id" value="<?php echo htmlspecialchars($eid); ?>">
            <input type="submit" value="Delete">
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['fundraiser_id'])) {
            if ($stmt->execute()) {
                echo "Record deleted successfully.<br><br>
                      <a href='fundraisers.php'>Return to the fundraisers form</a>";
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
    echo "Fundraiser ID is not set.";
}

$conn->close();
?>
