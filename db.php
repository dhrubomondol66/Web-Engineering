<?php
$host = 'localhost';
$dbname = 'docapp1'; // Your database name
$dbusername = 'root'; // Your MySQL username
$dbpassword = ''; // Your MySQL password

$mysqli = new mysqli($host, $dbusername, $dbpassword, $dbname);

if ($mysqli->connect_errno) {
    die("Connection error: " . $mysqli->connect_error);
}

return $mysqli;  // <-- Add this line
?>
