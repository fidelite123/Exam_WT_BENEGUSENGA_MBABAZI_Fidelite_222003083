<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" type="text/css" href="style.css" title="style 1" media="screen, tv, projection, handheld, print"/>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Reports Form</title>
  <style>
    /* CSS styles for navigation bar */
    nav {
      overflow: hidden;
    }

    nav a {
      float: left;
      color: #f2f2f2;
      text-align: center;
      padding: 14px 20px;
      text-decoration: none;
    }

    nav a:hover {
      background-color: #ddd;
      color: black;
    }

    .dropdown {
      float: left;
      overflow: hidden;
    }

    .dropdown .dropbtn {
      font-size: 16px;
      border: none;
      outline: none;
      color: white;
      padding: 14px 20px;
      background-color: inherit;
      font-family: inherit;
      margin: 0;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      background-color: #f9f9f9;
      min-width: 160px;
      z-index: 1;
    }

    .dropdown-content a {
      float: none;
      color: black;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
      text-align: left;
    }

    .dropdown-content a:hover {
      background-color: #ddd;
    }

    .dropdown:hover .dropdown-content {
      display: block;
    }
    header {
        background-color: black;
        padding: 30px;
    }
    /* Footer */
    footer {
        text-align: center;
        padding: 10px;
        background-color: black;
    }
  </style>
  <script>
    function confirmInsert() {
      return confirm('Are you sure you want to insert this record?');
    }
  </script>
</head>
<body bgcolor="darkgrey">
  <header>
    <!-- Navigation bar -->
    <nav>
      <a href="home.html">Home</a>
      <a href="projects.html">Projects</a>
      <a href="about.html">About Us</a>
      <a href="contact.html">Contact</a>
      <div class="dropdown">
         <button class="dropbtn">More</button>
        <div class="dropdown-content">
          <a href="reports.php">Reports</a>
          <a href="volunteers.php">Volunteers</a>
          <a href="events.php">Events</a>
          <a href="campaign.php">Campaigns</a>
          <a href="charities.php">Charities</a>
          <a href="donations.php">Donations</a>
          <a href="donorDetails.php">DonorDetails</a>
          <a href="fundraisers.php">Fundraisers</a>
          <a href="eventvolunteers.php">EventVolunteers</a>
        </div>
      </div>
      <div class="dropdown">
        <button class="dropbtn">Settings</button>
        <div class="dropdown-content">
          <a href="register.html">Register</a>
          <a href="login.html">Login</a>
          <a href="logout.php">Logout</a>
         </div> 
      </div>
      <br>
      <form method="GET" class="d-flex" role="search" action="search.php">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="query">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </nav>
    <!-- End of navigation bar -->
  </header>
  <section>
    <br><br>
    <h2><u>REPORT FORM</u></h2>
    <form method="post" onsubmit="return confirmInsert();">
      <label for="report_type">Report Type:</label>
      <input type="text" id="report_type" name="report_type" required><br><br>

      <label for="related_campaigns">Related Campaigns:</label>
      <input type="text" id="related_campaigns" name="related_campaigns" required><br><br>

      <label for="related_donors">Related Donors:</label>
      <input type="text" id="related_donors" name="related_donors" required><br><br>

      <label for="user_id">User ID:</label>
      <input type="number" id="user_id" name="user_id" required><br><br>

      <input type="submit" name="add" value="Insert">
    </form>

    <?php
    // Database connection
    require_once 'db_connection.php';

    // CRUD operations
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Insert operation
      if (isset($_POST['add'])) {
        $report_type = $_POST['report_type'];
        $related_campaigns = $_POST['related_campaigns'];
        $related_donors = $_POST['related_donors'];
        $user_id = $_POST['user_id'];

        $sql = "INSERT INTO reports (report_type, related_campaigns, related_donors, user_id) VALUES ('$report_type', '$related_campaigns', '$related_donors', '$user_id')";

        if ($conn->query($sql) === TRUE) {
          echo "New record created successfully";
        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }
      }
    }
    ?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail information Of Products</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

    <center><h2>Table of Reports</h2></center>
    <table border="3">
      <tr>
        <th>ID</th>
        <th>Report Type</th>
        <th>Related Campaigns</th>
        <th>Related Donors</th>
        <th>User ID</th>
        <th>Delete</th>
        <th>Update</th>
      </tr>
      <?php
      // Prepare SQL query to retrieve all reports
      $sql = "SELECT * FROM reports";
      $result = $conn->query($sql);

      // Check if there are any reports
      if ($result->num_rows > 0) {
        // Output data for each row
        while ($row = $result->fetch_assoc()) {
          $rid = $row['report_id']; // Fetch the Report ID
          echo "<tr>
              <td>" . $row['report_id'] . "</td>
              <td>" . $row['report_type'] . "</td>
              <td>" . $row['related_campaigns'] . "</td>
              <td>" . $row['related_donors'] . "</td>
              <td>" . $row['user_id'] . "</td>
              <td><a style='padding:4px' href='delete_reports.php?report_id=$rid'>Delete</a></td> 
              <td><a style='padding:4px' href='update_reports.php?id=$rid'>Update</a></td> 
            </tr>";
        }
      } else {
        echo "<tr><td colspan='8'>No data found</td></tr>";
      }

      // Close the database connection
      $conn->close();
      ?>
    </table>
  </section>

  <footer>
    <center> 
      <b><h2>UR CBE BIT &copy, 2024, Designed by BENEGUSENGA MBABAZI Fidelite</h2></b>
    </center>
  </footer>
</body>
</html>
