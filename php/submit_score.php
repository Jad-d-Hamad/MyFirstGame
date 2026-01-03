<?php
// submit_score.php
session_start();

// must be logged in (login.php sets this)
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo "NOT_LOGGED_IN";
    exit;
}

$dsn     = 'mysql:host=localhost;dbname=game_db;charset=utf8mb4';
$db_user = 'root';
$db_pass = '';

// read score from GET or POST
$score = 0;
if (isset($_POST['score'])) {
    $score = (int)$_POST['score'];
} elseif (isset($_GET['score'])) {
    $score = (int)$_GET['score'];
}

if ($score <= 0) {
    http_response_code(400);
    echo "INVALID_SCORE";
    exit;
}

$user_id = (int)$_SESSION['user_id'];

try {
    $pdo = new PDO($dsn, $db_user, $db_pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    $stmt = $pdo->prepare(
        "INSERT INTO highscores (user_id, score) VALUES (?, ?)"
    );
    $stmt->execute([$user_id, $score]);

    echo "SCORE_SAVED";
} catch (Exception $e) {
    http_response_code(500);
    echo "DB_ERROR";
}
