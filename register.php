<?php
// register.php
// 1) DB credentials
$host = '127.0.0.1';
$db   = 'myapp';
$user = 'root';        // default XAMPP username
$pass = '';            // default XAMPP password is empty
$charset = 'utf8mb4';

// 2) DSN and options
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // Production में detailed message न दिखाएँ — debugging के लिए temporarily echo कर सकते हैं
    exit('Database connection failed: ' . $e->getMessage());
}

// 3) Check POST data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // basic sanitation
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // simple validation
    if ($username === '' || $password === '') {
        echo "Username और Password दोनों भरें।";
        exit;
    }

    // 4) Check if username already exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        echo "यह username पहले से मौजूद है। कोई और नाम चुनें।";
        exit;
    }

    // 5) Hash the password (important!)
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // 6) Insert into DB
    $insert = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    try {
        $insert->execute([$username, $passwordHash]);
        // success — redirect या message दें
        header("Location: category.html"); // या किसी success पेज पर redirect
        exit;
    } catch (Exception $e) {
        echo "Insert failed: " . $e->getMessage();
        exit;
    }
} else {
    echo "Invalid request method.";
}
?>
