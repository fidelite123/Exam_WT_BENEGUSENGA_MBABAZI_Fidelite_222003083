<?php
// Check if the 'query' GET parameter is set
if (isset($_GET['query'])) {
    // Establish Database Connection
    require_once 'db_connection.php';

    // Sanitize input to prevent SQL injection
    $searchTerm = $conn->real_escape_string($_GET['query']);

    // Queries for different tables in a charity donation management system
    $queries = [
        'reports' => "SELECT report_type FROM reports WHERE report_type LIKE '%$searchTerm%'",
        'donations' => "SELECT payment_method FROM donations WHERE payment_method LIKE '%$searchTerm%'",
        'Campaigns' => "SELECT Name FROM Campaigns WHERE Name LIKE '%$searchTerm%'",
        'volunteers' => "SELECT Name FROM volunteers WHERE Name LIKE '%$searchTerm%'",
        'events' => "SELECT Name FROM events WHERE Name LIKE '%$searchTerm%'"
    ];

    // Output search results
    echo "<h2><u>Search Results:</u></h2>";

    foreach ($queries as $table => $sql) {
        $result = $conn->query($sql);
        echo "<h3>Table of $table:</h3>";
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<p>" . $row[array_keys($row)[0]] . "</p>"; // Dynamic field extraction from result
            }
        } else {
            echo "<p>No results found in $table matching the search term: '$searchTerm'</p>";
        }
    }

    // Close the connection
    $conn->close();
} else {
    echo "<p>No search term was provided.</p>";
}
?>
