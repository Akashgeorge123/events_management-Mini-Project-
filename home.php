<?php
include "includes/db.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Events Management</title>
    <link rel="stylesheet" href="css/style.css"> <!-- external CSS -->
</head>
<body>

<!-- Hero Section -->
<section class="hero">
    <div class="hero-content">
        <h1>Upcoming Festivals & Events</h1>
        <p>Experience the rich cultural heritage of our community through vibrant events and festivals.</p>
    </div>
</section>

<!-- Events Section -->
<section class="events">
    <h2>Featured Events</h2>
    <div class="event-grid">

    <?php
    $result = $conn->query("SELECT * FROM events ORDER BY date ASC");
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()) {
            echo "<div class='event-card'>";
            if($row['image']){
                echo "<img src='uploads/".$row['image']."' alt='Event Image'>";
            } else {
                echo "<img src='images/image3.jpg' alt='No Image'>";
            }
            echo "<h3>".$row['title']."</h3>";
            echo "<p>".$row['description']."</p>";
            echo "<p><b>Date:</b> ".$row['date']." | <b>Time:</b> ".$row['time']."</p>";
            echo "<p><b>Location:</b> ".$row['location']."</p>";
            echo "</div>";
        }
    } else {
        echo "<div class='event-card no-events'>";
        echo "<p>No upcoming events at the moment. Please check back later.</p>";
        echo "</div>";
    }
    ?>

    </div>
</section>

<!-- Footer -->
<footer>
    <div class="footer-links">
        <a href="login.php">Login</a> | 
        <a href="register.php">Register</a>
    </div>
</footer>

</body>
</html>
