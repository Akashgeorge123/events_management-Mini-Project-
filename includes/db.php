<?php
$conn = new mysqli("localhost","root","1234","events_management");
if($conn->connect_error) {
  die("Connection error: ".$conn->connect_error);
}
?>