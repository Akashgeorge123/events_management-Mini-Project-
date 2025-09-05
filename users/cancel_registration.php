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
    $conn->query("DELETE FROM registrations WHERE student_id=$student_id AND event_id=$event_id");
    $_SESSION['msg'] = "Your registration has been cancelled.";
}
header("Location: dashboard.php");
exit();
?>
