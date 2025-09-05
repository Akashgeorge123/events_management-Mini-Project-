<?php
session_start();
include "../includes/db.php";

if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin'){
    header("Location: ../login.php");
    exit();
}

$event_id = $_GET['id'] ?? null;

if($event_id){
    $conn->query("DELETE FROM events WHERE id=$event_id");
    $conn->query("DELETE FROM registrations WHERE event_id=$event_id"); // also remove registrations
}

header("Location: dashboard.php");
exit();
?>
