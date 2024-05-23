<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" type="text/css" href="style.css" title="style 1" media="screen, tv, projection, handheld, print"/>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Events Form</title>
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
<body bgcolor="#FFFFFF">
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
    <h2><u>EVENTS FORM</u></h2>
    <form method="post" onsubmit="return confirmInsert();">
      <label for="name">Name:</label>
      <input type="text" id="name" name="name" required><br><br>

      <label for="date">date:</label>
      <input type="Date" id="date" name="date" required><br><br>

      <label for="location">location:</label>
      <input type="text" id="location" name="location" required><br><br>

      <label for="description">description:</label>
      <input type="text" id="description" name="description" required><br><br>

      <label for="goal">goal:</label>
      <input type="text" id="goal" name="goal" required><br><br> 

      <label for="campaign_id">Campaign ID:</label>
<input type="number" id="campaign_id" name="campaign_id" required><br><br>

      <input type="submit" name="add" value="Insert">
    </form>

    <?php
    // Database connection
    require_once 'db_connection.php';

    // CRUD operations
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Insert operation
     $name = $_POST['name'];
$date = $_POST['date'];
$location = $_POST['location'];
$description = $_POST['description'];
$goal = $_POST['goal'];
$campaign_id = $_POST['campaign_id']; // Corrected variable name

$sql = "INSERT INTO events (name, date, location, description, goal, campaign_id) VALUES ('$name', '$date', '$location', '$description', '$goal','$campaign_id')";


        if ($conn->query($sql) === TRUE) {
          echo "New record created successfully";
        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }
      }
    
    ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail information Of events</title>
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
    <center><h2>Table of Events</h2></center>
    <table border="3">
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>date</th>
        <th>location</th>
        <th>Adescription</th>
        <th>goal</th>
         <th>campaign_id</th>
        <th>Delete</th>
        <th>Update</th>
      </tr>
      <?php
      // Prepare SQL query to retrieve all volunteers
      $sql = "SELECT * FROM events";
      $result = $conn->query($sql);

      // Check if there are any volunteers
      if ($result->num_rows > 0) {
        // Output data for each row
        while ($row = $result->fetch_assoc()) {
          $eid = $row['event_id']; // Fetch the Volunteer ID
          echo "<tr>
      <td>" . $row['event_id'] . "</td>
      <td>" . $row['name'] . "</td>
      <td>" . $row['date'] . "</td>
      <td>" . $row['location'] . "</td>
      <td>" . $row['description'] . "</td>
      <td>" . $row['goal'] . "</td>
      <td>" . $row['campaign_id'] . "</td> <!-- Corrected array key name -->
      <td><a style='padding:4px' href='delete_events.php?event_id=$eid'>Delete</a></td> 
      <td><a style='padding:4px' href='update_events.php?event_id=$eid'>Update</a></td> 
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
      <h2>UR CBE BIT &copy, 2024, Designed by BENEGUSENGA MBABAZI Fidelite</h2>
    </center>
  </footer>
</body>
</html>
