<?php
$host = "localhost";
$dbname = "fitgear";
$username = "root"; // or your DB username
$password = "";     // or your DB password

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
