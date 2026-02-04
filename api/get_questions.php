<?php
// 1. DATABASE CONNECTION (Integrated as requested)
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
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    header('Content-Type: application/json');
    echo json_encode(["error" => "Connection failed: " . $e->getMessage()]);
    exit;
}

// 2. LOGIC FOR LEVEL-BASED QUESTION COUNTS
header("Content-Type: application/json");

// Get the level from the JavaScript fetch request
$level = isset($_GET['level']) ? $_GET['level'] : 'easy';

// Define limits based on your rules: Easy=20, Medium=10, Hard=5
if ($level === 'easy') {
    $limit = 20;
} elseif ($level === 'medium') {
    $limit = 10;
} else {
    $limit = 5;
}

// 3. FETCH DATA
try {
    // We use a prepared statement with the level to prevent SQL injection
    $stmt = $pdo->prepare("SELECT question, answer, hint FROM questions WHERE difficulty = ? ORDER BY RAND() LIMIT $limit");
    $stmt->execute([$level]);
    $questions = $stmt->fetchAll();

    // Send the questions back to the game
    echo json_encode($questions);

} catch (Exception $e) {
    echo json_encode(["error" => "Query failed: " . $e->getMessage()]);
}
?>