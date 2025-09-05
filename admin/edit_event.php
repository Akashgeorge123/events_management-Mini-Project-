<?php
session_start();
include "../includes/db.php";

if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin'){
    header("Location: ../login.php");
    exit();
}

$event_id = $_GET['id'] ?? null;

if(!$event_id){
    header("Location: dashboard.php");
    exit();
}

if(isset($_FILES['image']) && $_FILES['image']['name'] != ''){
    $image = time() . "_" . $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/".$image);
    $conn->query("UPDATE events SET image='$image' WHERE id=$event_id");
}

$event_result = $conn->query("SELECT * FROM events WHERE id=$event_id");
$event = $event_result->fetch_assoc();

if(isset($_POST['update'])){
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $location = $_POST['location'];

    $conn->query("UPDATE events SET title='$title', description='$description', date='$date', time='$time', location='$location' WHERE id=$event_id");
    $success = "Event updated successfully!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Event</title>
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
    <h2>Edit Event</h2>

    <?php if(isset($success)) echo "<p style='color:green;'>$success</p>"; ?>

    <form method="post">
        <input type="text" name="title" value="<?php echo $event['title']; ?>" required><br>
        <textarea name="description" required><?php echo $event['description']; ?></textarea><br>
        <input type="date" name="date" value="<?php echo $event['date']; ?>" required><br>
        <input type="time" name="time" value="<?php echo $event['time']; ?>" required><br>
        <input type="text" name="location" value="<?php echo $event['location']; ?>" required><br>
        <input type="file" name="image" accept="image/*"><br>
        <?php if($event['image']) echo "<img src='../uploads/".$event['image']."' style='max-width:150px;'><br>"; ?>
        <button type="submit" name="update">Update Event</button>
    </form>
</div>
</body>
</html>
