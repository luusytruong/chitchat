<?php

include 'db.php';

// Create db if db does not exist
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ( $conn->query( $sql ) === TRUE ) {
    echo "Database $dbname has been created.\n";
} else {
    echo 'Error creating db: ' . $conn->error . '\n';
}

// Select db
$conn->select_db( $dbname );

// Create table users
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

$conn->query( $sql );

// Create table groups
$sql = "CREATE TABLE IF NOT EXISTS groups (
    id INT AUTO_INCREMENT PRIMARY KEY,
    group_name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

$conn->query( $sql );

// Create table group_members
$sql = "CREATE TABLE IF NOT EXISTS group_members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    group_id INT NOT NULL,
    user_id INT NOT NULL,
    FOREIGN KEY (group_id) REFERENCES groups(id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    UNIQUE (group_id, user_id)
)";

$conn->query( $sql );

// Create table messages
$sql = "CREATE TABLE IF NOT EXISTS messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT NOT NULL,
    receiver_id INT,
    group_id INT,
    message TEXT NOT NULL,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES users(id),
    FOREIGN KEY (receiver_id) REFERENCES users(id),
    FOREIGN KEY (group_id) REFERENCES groups(id)
)";

$conn->query( $sql );

// Close connection
$conn->close();
echo 'All tables have been created.';

?>