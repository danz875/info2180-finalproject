<?php
$host = 'localhost';
$dbname = 'dolphin_crm';
$username = 'root'; // your mysql username, change if you have a different username
$password = ''; // your mysql password, change if you have a different password

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}