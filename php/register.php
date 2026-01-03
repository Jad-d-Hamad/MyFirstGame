<?php
// ==== CONFIG ====
$dsn     = 'mysql:host=localhost;dbname=game_db;charset=utf8mb4';
$db_user = 'root';      // XAMPP default
$db_pass = '';          // empty password by default

$error   = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm']  ?? '';

    if ($username === '' || $password === '' || $confirm === '') {
        $error = 'All fields are required.';
    } elseif ($password !== $confirm) {
        $error = 'Passwords do not match.';
    } else {
        try {
            $pdo = new PDO($dsn, $db_user, $db_pass, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);

            // check if username exists
            $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ?');
            $stmt->execute([$username]);
            if ($stmt->fetch()) {
                $error = 'Username already taken.';
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $pdo->prepare(
                    'INSERT INTO users (username, password_hash) VALUES (?, ?)'
                );
                $stmt->execute([$username, $hash]);

                $success = 'Account created successfully.';
            }
        } catch (Exception $e) {
            $error = 'Database error. Check XAMPP/MySQL.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Game Register</title>
<style>
    body { background:#050018; color:#eee; font-family:Arial, sans-serif; text-align:center; }
    .box { margin:80px auto; max-width:360px; padding:24px 28px; background:#11153a;
           border-radius:8px; box-shadow:0 0 24px rgba(0,0,0,0.6); }
    h1 { color:#00ffd0; margin-bottom:18px; }
    label { display:block; text-align:left; margin-top:12px; font-size:14px; color:#8ef; }
    input[type=text], input[type=password] {
        width:100%; padding:8px 10px; margin-top:4px;
        border-radius:4px; border:1px solid #333; background:#060820; color:#fff;
    }
    .btn {
        margin-top:18px; width:100%; padding:10px;
        border:none; border-radius:4px;
        background:#ff00ba; color:#fff; font-weight:bold; cursor:pointer;
    }
    .btn:hover { background:#ff33c7; }
    .msg-error   { color:#ff6b6b; margin-top:10px; }
    .msg-success { color:#7dff7d; margin-top:10px; }
</style>
</head>
<body>
<div class="box">
    <h1>Create Account</h1>

    <?php if ($error): ?>
        <div class="msg-error"><?php echo htmlspecialchars($error); ?></div>
    <?php elseif ($success): ?>
        <div class="msg-success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>

    <form method="post" action="register.php">
        <label>Username
            <input type="text" name="username" maxlength="50" required>
        </label>
        <label>Password
            <input type="password" name="password" required>
        </label>
        <label>Confirm Password
            <input type="password" name="confirm" required>
        </label>
        <button class="btn" type="submit">Register</button>
    </form>
</div>
</body>
</html>
