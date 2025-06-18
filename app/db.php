<?php
$conn = new mysqli("db", "root", "root", "travel_blog");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

