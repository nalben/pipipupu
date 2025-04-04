<?php
header('Content-Type: application/json; charset=UTF-8');

$response = [
    "success" => false,
    "errors" => ["password" => "Неверный логин или пароль."]
];

$login = $_POST['login'] ?? '';
$password = $_POST['password'] ?? '';

require 'db.php'; 

$stmt = $pdo->prepare("SELECT user_id, username, password FROM users WHERE login = ?");
$stmt->execute([$login]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    session_start();
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['username'] = $user['username'];
    
    $response = ["success" => true];
}

echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
exit;
