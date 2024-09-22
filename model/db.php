<?php

// host info
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "realtime_chat_db";

// connect host
$conn = mysqli_connect($servername, $username, $password, $dbname);

// check connection host
if (!$conn) {
    die("Connection error: " . mysqli_connect_error());
}

?>