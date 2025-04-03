<?php
session_start();
require 'db.php';

header('Content-Type: application/json');

$response = ['success' => false, 'error' => '', 'liked' => false, 'like_count' => 0];


if (!isset($_SESSION['user_id'])) {
    $response['error'] = 'Пользователь не авторизован.';
    echo json_encode($response);
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['photo_id'])) {
        $photo_id = intval($data['photo_id']);

        try {
            // Проверяем, есть ли уже лайк
            $stmt = $pdo->prepare("SELECT id FROM likes WHERE user_id = ? AND photo_id = ?");
            $stmt->execute([$user_id, $photo_id]);
            $likeExists = $stmt->fetch();

            if ($likeExists) {
                // Если лайк есть, удаляем его
                $stmt = $pdo->prepare("DELETE FROM likes WHERE user_id = ? AND photo_id = ?");
                $stmt->execute([$user_id, $photo_id]);
                $response['liked'] = false;
            } else {
                // Если лайка нет, добавляем
                $stmt = $pdo->prepare("INSERT INTO likes (photo_id, user_id, created_at) VALUES (?, ?, NOW())");
                $stmt->execute([$photo_id, $user_id]);
                $response['liked'] = true;
            }

            // Получаем текущее количество лайков
            $stmt = $pdo->prepare("SELECT COUNT(*) AS like_count FROM likes WHERE photo_id = ?");
            $stmt->execute([$photo_id]);
            $response['like_count'] = $stmt->fetchColumn();

            $response['success'] = true;
        } catch (PDOException $e) {
            $response['error'] = 'Ошибка базы данных: ' . $e->getMessage();
        }
    } else {
        $response['error'] = 'Некорректные данные.';
    }
} else {
    $response['error'] = 'Неверный метод запроса.';
}

echo json_encode($response);
