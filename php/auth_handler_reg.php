<?php
header('Content-Type: application/json');
require 'db.php';

$response = ['success' => false, 'errors' => []];

$login = trim($_POST['login1'] ?? '');
$password = trim($_POST['password1'] ?? '');
$username = trim($_POST['username1'] ?? '');

// Проверка на пустые поля
if (!$login || !$username) {
    if (!$login) $response['errors']['login'] = true;
    if (!$username) $response['errors']['username'] = true;
} else {
    // Проверка только логина на уникальность
    $stmt = $pdo->prepare("SELECT 1 FROM users WHERE login = ?");
    $stmt->execute([$login]);
    if ($stmt->rowCount() > 0) {
        $response['errors']['login'] = true;
    }
}

// Если ошибок нет, создаем пользователя
if (empty($response['errors'])) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (login, password, username) VALUES (?, ?, ?)");
    
    if ($stmt->execute([$login, $hashedPassword, $username])) {
        session_start();
        $_SESSION['user_id'] = $pdo->lastInsertId();
        $_SESSION['username'] = $username;
        $response['success'] = true;
    } else {
        $response['errors']['general'] = true;
    }
}

echo json_encode($response);
exit;
