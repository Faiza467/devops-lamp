<?php
$conn = new mysqli("db", "root", "rootpassword", "travel_blog");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
