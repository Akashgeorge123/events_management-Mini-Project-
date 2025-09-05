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

$registrations = $conn->query("
    SELECT registrations.id as reg_id, users.name, users.email, registrations.paid
    FROM registrations 
    JOIN users ON registrations.student_id = users.id 
    WHERE registrations.event_id = $event_id
");

while($row = $registrations->fetch_assoc()){
    echo "<tr>";
    echo "<td>".$row['name']."</td>";
    echo "<td>".$row['email']."</td>";  
    echo "<td>";
    echo "<form method='post' action='update_payment.php'>
            <input type='hidden' name='reg_id' value='".$row['reg_id']."'>
            <select name='paid' onchange='this.form.submit()'>
                <option value='no' ".($row['paid']=='no'?'selected':'').">Not Paid</option>
                <option value='yes' ".($row['paid']=='yes'?'selected':'').">Paid</option>
            </select>
          </form>";
    echo "</td>";
    echo "</tr>";
}

// Fetch event info
$event_result = $conn->query("SELECT * FROM events WHERE id=$event_id");
$event = $event_result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registrations - <?php echo $event['title']; ?></title>
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
    <h2>Registrations for "<?php echo $event['title']; ?>"</h2>

    <?php
    $registrations = $conn->query("
        SELECT users.name, users.email 
        FROM registrations 
        JOIN users ON registrations.student_id = users.id 
        WHERE registrations.event_id = $event_id
    ");

    if($registrations->num_rows > 0){
        echo "<table>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                </tr>";
        while($row = $registrations->fetch_assoc()){
            echo "<tr>
                    <td>".$row['name']."</td>
                    <td>".$row['email']."</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No students registered yet.</p>";
    }
    ?>
</div>
</body>
</html>
