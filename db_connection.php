<?php
$servername = "localhost";
$username = "Fidelite";
$password = "222003083";
$dbname = "charity_donation_management_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
