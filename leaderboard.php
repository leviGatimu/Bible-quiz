<?php 
// 1. Force error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 2. Establish connection directly to avoid path issues
$host = "localhost";
$db   = "bible_games";
$user = "root";
$pass = ""; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Database Connection Failed: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bible Insights - Leaderboard</title>
    <style>
        :root { --primary: #2d3748; --accent: #3182ce; --bg: #f7fafc; }
        body { font-family: 'Segoe UI', sans-serif; background: var(--bg); margin: 0; }
        .navbar { background: var(--primary); color: white; padding: 1rem 10%; text-align: center; }
        .container { max-width: 800px; margin: 2rem auto; padding: 1rem; }
        .card { background: white; padding: 2.5rem; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background: #edf2f7; padding: 15px; text-align: left; color: #4a5568; }
        td { padding: 15px; border-bottom: 1px solid #edf2f7; }
        .rank-gold { color: #d69e2e; font-weight: bold; }
        .score-pill { background: #bee3f8; color: #2b6cb0; padding: 5px 12px; border-radius: 20px; font-weight: bold; }
        .btn-back { display: inline-block; margin-top: 25px; padding: 12px 25px; background: var(--accent); color: white; text-decoration: none; border-radius: 8px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="navbar"><h1>Academy Leaderboard</h1></div>

    <main class="container">
        <div class="card">
            <h2>🏆 Top Student Performances</h2>
            <table>
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Student Name</th>
                        <th>Level</th>
                        <th>Marks (%)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $pdo->query("SELECT student_name, score, level FROM scores ORDER BY score DESC, date_played DESC LIMIT 10");
                    $rank = 1;
                    while($row = $stmt->fetch()) {
                        $rankClass = ($rank === 1) ? 'rank-gold' : '';
                        echo "<tr>
                                <td class='$rankClass'>#$rank</td>
                                <td>" . htmlspecialchars($row['student_name']) . "</td>
                                <td>" . ucfirst($row['level']) . "</td>
                                <td><span class='score-pill'>{$row['score']}%</span></td>
                              </tr>";
                        $rank++;
                    }
                    ?>
                </tbody>
            </table>
            <a href="index.php" class="btn-back">Take Test Again</a>
        </div>
    </main>
</body>
</html>