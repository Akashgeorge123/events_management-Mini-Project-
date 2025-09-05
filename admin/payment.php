<?php
session_start();
include "../includes/db.php";

if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin'){
    header("Location: ../login.php");
    exit();
}

if(isset($_POST['reg_id']) && isset($_POST['paid'])){
    $reg_id = $_POST['reg_id'];
    $paid = $_POST['paid'] === 'yes' ? 'yes' : 'no';

    $conn->query("UPDATE registrations SET paid='$paid' WHERE id=$reg_id");
}

header("Location: view_registrations.php?id=".$_POST['event_id']);
exit();
?>
