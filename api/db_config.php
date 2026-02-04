<?php
// Database configuration
$host = "localhost";
$db   = "bible_games";
$user = "root";
$pass = ""; 
$charset = "utf8mb4";

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     // Create the global $pdo variable
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     // If this fails, we want to know EXACTLY why
     die("Connection failed: " . $e->getMessage());
}
?>