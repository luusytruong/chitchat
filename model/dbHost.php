<?php

// host info
$servername = "103.97.126.22";
$username = "yrytecvg_chitchat";
$password = "yrytecvg_chitchat";
$dbname = "yrytecvg_chitchat";

// connect host
try {
    $pdo = new PDO("mysql:host=$servername; dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "cnt\n";
} catch (PDOException $e) {
    echo "" . $e->getMessage() . "\n";
}
