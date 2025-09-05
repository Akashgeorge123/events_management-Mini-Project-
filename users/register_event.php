<?php
session_start();
include "../includes/db.php";

if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student'){
    header("Location: ../login.php");
    exit();
}

$student_id = $_SESSION['user_id'];
$event_id = $_GET['event_id'] ?? null;

if($event_id){
    // Check if already registered
    $check = $conn->query("SELECT * FROM registrations WHERE student_id=$student_id AND event_id=$event_id");
    if($check->num_rows > 0){
        $_SESSION['msg'] = "You are already registered for this event.";
    } else {
        $conn->query("INSERT INTO registrations (student_id, event_id, paid) VALUES ($student_id, $event_id, 'no')");
        $_SESSION['msg'] = "Successfully registered for the event!";
    }
}
header("Location: dashboard.php");
exit();
?>
