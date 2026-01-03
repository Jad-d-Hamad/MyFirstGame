<?php
// highscores.php
session_start();

// ===== REQUIRE LOGIN =====
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo "<!DOCTYPE html><html><body style='background:#050018;color:#eee;
          font-family:Arial;text-align:center;margin-top:80px;'>
          <h2>You must be logged in to view highscores.</h2>
          <p><a href='login.php' style='color:#00ffd0;'>Go to Login</a></p>
          </body></html>";
    exit;
}

$dsn     = 'mysql:host=localhost;dbname=game_db;charset=utf8mb4';
$db_user = 'root';
$db_pass = '';

$error    = '';
$rows     = [];
$user_best = null;

try {
    $pdo = new PDO($dsn, $db_user, $db_pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    // ===== LEADERBOARD: BEST SCORE PER USER =====
    $stmt = $pdo->query("
        SELECT u.username,
               MAX(h.score) AS best_score,
               MIN(h.created_at) AS first_time
        FROM highscores h
        JOIN users u ON h.user_id = u.id
        GROUP BY h.user_id, u.username
        ORDER BY best_score DESC, first_time ASC
        LIMIT 20
    ");
    $rows = $stmt->fetchAll();

    // ===== LOGGED-IN USER BEST SCORE =====
    $stmt2 = $pdo->prepare("
        SELECT MAX(score) AS best_score
        FROM highscores
        WHERE user_id = ?
    ");
    $stmt2->execute([$_SESSION['user_id']]);
    $user_best = $stmt2->fetchColumn();

} catch (Exception $e) {
    $error = 'Database error. Check XAMPP/MySQL.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Game Highscores</title>
<style>
    body { background:#050018; color:#eee; font-family:Arial,sans-serif; text-align:center; }
    .box { margin:60px auto; max-width:600px; padding:24px 28px; background:#11153a;
           border-radius:8px; box-shadow:0 0 24px rgba(0,0,0,0.6); }
    h1 { color:#00ffd0; margin-bottom:10px; }
    table { width:100%; border-collapse:collapse; margin-top:10px; }
    th, td { padding:8px 6px; border-bottom:1px solid #222; }
    th { color:#8ef; }
    tr:nth-child(even) { background:#151a40; }
    tr:nth-child(odd)  { background:#101433; }
    .rank { width:40px; }
</style>
</head>
<body>
<div class="box">
    <h1>Highscores</h1>
<p>Logged in as <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong></p>
<p>
  <a href="logout.php" style="color:#ff6b6b;">Log out</a>
</p>


    <?php if ($user_best !== null): ?>
        <p>Your best score: <strong><?php echo (int)$user_best; ?></strong></p>
    <?php endif; ?>

    <?php if ($error): ?>
        <div style="color:#ff6b6b;"><?php echo htmlspecialchars($error); ?></div>
    <?php elseif (!$rows): ?>
        <div>No highscores yet.</div>
    <?php else: ?>
        <table>
            <tr>
                <th class="rank">#</th>
                <th>Player</th>
                <th>Best Score</th>
                <th>Since</th>
            </tr>
            <?php $i = 1; foreach ($rows as $r): ?>
                <tr>
                    <td class="rank"><?php echo $i++; ?></td>
                    <td><?php echo htmlspecialchars($r['username']); ?></td>
                    <td><?php echo (int)$r['best_score']; ?></td>
                    <td><?php echo htmlspecialchars($r['first_time']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>
</body>
</html>
