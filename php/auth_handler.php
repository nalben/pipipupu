<?php
header('Content-Type: application/json; charset=UTF-8');

$response = [
    "success" => false,
    "errors" => ["password" => "Неверный логин или пароль."],
    "debug" => []
];

$login = $_POST['login'] ?? '';
$password = $_POST['password'] ?? '';

$response['debug']['received_login'] = $login;
$response['debug']['received_password'] = str_repeat("*", strlen($password));
$response['debug']['password_length'] = strlen($password);
$response['debug']['password_hex'] = bin2hex($password);
$response['debug']['password_encoding'] = mb_detect_encoding($password, mb_detect_order(), true);

require 'db.php'; // Подключение к базе данных

$stmt = $pdo->prepare("SELECT user_id, username, password FROM users WHERE login = ?");
$stmt->execute([$login]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    $response['debug']['db_user_found'] = true;
    $response['debug']['db_user_password_hash'] = $user['password'];
    $response['debug']['stored_hash_length'] = strlen($user['password']);

    // Проверяем пароль
    if (password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        
        $response['success'] = true;
        unset($response['errors']);
        $response['debug']['password_match'] = true;
    } else {
        $response['debug']['password_match'] = false;
    }
} else {
    $response['debug']['db_user_found'] = false;
}

echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
exit;
