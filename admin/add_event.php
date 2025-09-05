<?php
session_start();
include "../includes/db.php";

if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin'){
    header("Location: ../login.php");
    exit();
}

if(isset($_POST['add'])){
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $location = $_POST['location'];

    $image = null;
    if(isset($_FILES['image']) && $_FILES['image']['name'] != ''){
        $image = time() . "_" . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/".$image);
    }

    $conn->query("INSERT INTO events (title, description, date, time, location) VALUES ('$title','$description','$date','$time','$location')");
    $success = "Event added successfully!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Event</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="navbar">
    <h2>Admin Dashboard</h2>
    <div class="nav-links">
        <a href="dashboard.php">Dashboard</a>
        <a href="../home.php">Home</a>
        <a href="../logout.php">Logout</a>
    </div>
</div>

<div class="dashboard">
    <h2>Add Event</h2>

    <?php if(isset($success)) echo "<p style='color:green;'>$success</p>"; ?>

    <form method="post">
        <input type="text" name="title" placeholder="Event Title" required><br>
        <textarea name="description" placeholder="Description" required></textarea><br>
        <input type="date" name="date" required><br>
        <input type="time" name="time" required><br>
        <input type="text" name="location" placeholder="Location" required><br>
        <input type="file" name="image" accept="image/*"><br>
        <button type="submit" name="add">Add Event</button>
    </form>
</div>
</body>
</html>
