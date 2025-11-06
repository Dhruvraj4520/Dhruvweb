<?php
// login.php
$host = '127.0.0.1'; $db = 'myapp'; $user = 'root'; $pass = ''; $charset='utf8mb4';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') { exit('Fill both.'); }

    $stmt = $pdo->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $userRow = $stmt->fetch();
    if ($userRow && password_verify($password, $userRow['password'])) {
        // login success
        session_start();
        $_SESSION['user_id'] = $userRow['id'];
        $_SESSION['username'] = $username;
        header("Location: category.html");
        exit;
    } else {
        echo "Invalid username/password.";
    }
}
?>
