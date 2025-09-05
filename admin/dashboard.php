<?php
session_start();
include "../includes/db.php";
if($_SESSION['role'] !== 'admin'){ header("Location: ../login.php"); exit(); }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="navbar">
    <h2>Admin Dashboard</h2>
    <div class="nav-links">
        <a href="dashboard.php">Dashboard</a>
        <a href="add_event.php">Add Event</a>
        <a href="../home.php">Home</a>
        <a href="../logout.php">Logout</a>
    </div>
</div>

<div class="dashboard">
    <h2>All Events</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Date</th>
            <th>Time</th>
            <th>Location</th>
            <th>Actions</th>
        </tr>
        <?php
        $result = $conn->query("SELECT * FROM events ORDER BY date, time");
        while($row = $result->fetch_assoc()){
            echo "<tr>";
            echo "<td>".$row['id']."</td>";
            echo "<td>".$row['title']."</td>";
            echo "<td>".$row['date']."</td>";
            echo "<td>".$row['time']."</td>";
            echo "<td>".$row['location']."</td>";
            echo "<td>
                    <a href='edit_event.php?id=".$row['id']."'>Edit</a> |
                    <a href='delete_event.php?id=".$row['id']."' onclick='return confirm(\"Are you sure?\")'>Delete</a> |
                    <a href='view_registrations.php?id=".$row['id']."'>Registrations</a>
                  </td>";
            echo "</tr>";
        }
        ?>
    </table>
</div>
</body>
</html>
