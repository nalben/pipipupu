<?php
header('Content-Type: application/json'); // Указываем, что ответ будет в формате JSON

require 'db.php'; // Подключаем базу данных

$response = ['success' => false, 'errors' => []];

// Получаем данные из POST-запроса
$login = trim($_POST['login1'] ?? '');
$password = trim($_POST['password1'] ?? '');
$username = trim($_POST['username1'] ?? '');

// Проверяем логин
if (!empty($login)) {
    $stmt = $pdo->prepare("SELECT 1 FROM users WHERE login = ?");
    $stmt->execute([$login]);
    if ($stmt->rowCount() > 0) {
        $response['errors']['login'] = true; // Логин уже занят
    } else {
        $response['errors']['login'] = false; // Логин уникален
    }
} else {
    $response['errors']['login'] = true; // Логин пустой
}

// Проверяем никнейм
if (!empty($username)) {
    $stmt = $pdo->prepare("SELECT 1 FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->rowCount() > 0) {
        $response['errors']['username'] = true; // Никнейм уже занят
    } else {
        $response['errors']['username'] = false; // Никнейм уникален
    }
} else {
    $response['errors']['username'] = true; // Никнейм пустой
}

// Если нет ошибок, добавляем запись в базу данных
if (empty(array_filter($response['errors']))) { // Проверяем, есть ли хоть одна ошибка
    // Хэшируем пароль
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (login, password, username) VALUES (?, ?, ?)");
    if ($stmt->execute([$login, $hashedPassword, $username])) {
        session_start();
        $_SESSION['user_id'] = $pdo->lastInsertId(); // Сохраняем ID нового пользователя в сессии
        $_SESSION['username'] = $username;
        $response['success'] = true; // Регистрация успешна
    } else {
        $response['errors']['general'] = true; // Общая ошибка базы данных
    }
}

echo json_encode($response); // Возвращаем JSON-ответ
exit;
