<?php

$mysqli = new mysqli("localhost", "root", "", "newdatabase");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
} else {
    echo "Connected";
}

?>
