<?php

// host info
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "realtime_chat_db";

// connect host
$conn = mysqli_connect($servername, $username, $password);

// check connection host
if (!$conn) {
    die("Connection error: " . mysqli_connect_error());
}

// create db if db does not exist
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ( $conn->query( $sql ) === TRUE ) {
    echo "Database $dbname has been created.\n";
} else {
    echo 'Error creating db: ' . $conn->error . "\n";
}

// connect db
$conn = mysqli_connect($servername, $username, $password, $dbname);

// check connection host
if (!$conn) {
    die("Connection error: " . mysqli_connect_error());
}

// select db
$conn->select_db( $dbname );


?>