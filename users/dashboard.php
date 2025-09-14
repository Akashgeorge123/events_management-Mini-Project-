<?php
session_start();
include "../includes/db.php";

// Restrict access to students only
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'student'){ 
    header("Location: ../login.php"); 
    exit(); 
}

$student_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <h2>Student Dashboard</h2>
    <div class="nav-links">
        <a href="dashboard.php">Dashboard</a>
        <a href="../home.php">Home</a>
        <a href="../logout.php">Logout</a>
    </div>
</div>

<div class="dashboard">
    <h2>Available Events</h2>

    <?php
    // Show success message if exists
    if(isset($_SESSION['msg'])){
        echo "<p style='color:green; text-align:center;'>".$_SESSION['msg']."</p>";
        unset($_SESSION['msg']);
    }

    // Fetch events safely
    $query = "SELECT * FROM events ORDER BY date, time";
    $events = $conn->query($query);

    if(!$events){
        echo "<p style='color:red; text-align:center;'>Error fetching events: ".$conn->error."</p>";
    } elseif($events->num_rows > 0){
        while($event = $events->fetch_assoc()){
            echo "<div class='event'>";

            // Event image
            if(!empty($event['image'])){
                echo "<img src='../uploads/".$event['image']."' alt='Event Image' style='max-width:200px; display:block; margin-bottom:10px;'>";
            } else {
                echo "<img src='../images/image3.jpg' alt='No Image' style='max-width:200px; display:block; margin-bottom:10px;'>";
            }

            echo "<h3>".htmlspecialchars($event['title'])."</h3>";
            echo "<p>".htmlspecialchars($event['description'])."</p>";
            echo "<p><b>Date:</b> ".$event['date']." | <b>Time:</b> ".$event['time']."</p>";
            echo "<p><b>Location:</b> ".htmlspecialchars($event['location'])."</p>";

            // Check if student registered
            $check = $conn->query("SELECT * FROM registrations WHERE student_id=$student_id AND event_id=".$event['id']);
            if($check && $check->num_rows > 0){
                $reg = $check->fetch_assoc();
                echo "<p>Payment Status: ".($reg['paid']=='yes' ? 'Paid' : 'Not Paid')."</p>";
                echo "<a href='cancel_registration.php?event_id=".$event['id']."'>Cancel Registration</a>";
            } else {
                echo "<a href='register_event.php?event_id=".$event['id']."'>Register</a>";
            }

            echo "</div>"; // end event
        }
    } else {
        echo "<p style='text-align:center;'>No events available at the moment. Please check back later.</p>";
    }
    ?>
</div>

</body>
</html>
