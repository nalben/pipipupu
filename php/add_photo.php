<?php
session_start();
require 'db.php';
header('Content-Type: application/json');

$response = ['success' => false, 'error' => ''];

// Проверяем авторизацию пользователя
if (!isset($_SESSION['user_id'])) {
    $response['error'] = 'Пользователь не авторизован.';
    echo json_encode($response);
    exit;
}

$author_id = $_SESSION['user_id']; // Получаем ID текущего авторизованного пользователя

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['file'], $_POST['photo_title'])) {
        $title = trim($_POST['photo_title']);
        $description = isset($_POST['photo_description']) ? trim($_POST['photo_description']) : null;
        $tags = isset($_POST['photo_tag']) ? json_decode($_POST['photo_tag'], true) : []; // Теги
        $file = $_FILES['file'];

        // Проверяем корректность загружаемого файла
        $uploadDir = 'uploads/';
        $filePath = $uploadDir . basename($file['name']);
        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            try {
                // Сохраняем фото в таблице `photos`
                $stmt = $pdo->prepare("INSERT INTO photos (path, title, description, author_id, create_at) VALUES (?, ?, ?, ?, NOW())");
                $stmt->execute([$filePath, $title, $description, $author_id]);

                $photo_id = $pdo->lastInsertId(); // ID добавленного фото

                // Обработка тегов
                if (!empty($tags)) {
                    foreach ($tags as $tag) {
                        // Проверяем, существует ли тег в таблице `tags`
                        $tagSelectStmt = $pdo->prepare("SELECT tag_id FROM tags WHERE name = ?");
                        $tagSelectStmt->execute([$tag]);
                        $tag_id = $tagSelectStmt->fetchColumn();

                        if (!$tag_id) {
                            // Если тега нет, добавляем его
                            $tagInsertStmt = $pdo->prepare("INSERT INTO tags (name) VALUES (?)");
                            $tagInsertStmt->execute([$tag]);
                            $tag_id = $pdo->lastInsertId(); // Получаем ID нового тега
                        }

                        // Убедимся, что tag_id найден
                        if (!$tag_id) {
                            throw new Exception("Не удалось найти или добавить тег: $tag");
                        }

                        // Связываем тег с фото
                        $photoTagStmt = $pdo->prepare("INSERT INTO photo_tag (photo_id, tag_id) VALUES (?, ?)");
                        $photoTagStmt->execute([$photo_id, $tag_id]);
                    }
                }

                $response['success'] = true;
            } catch (PDOException $e) {
                $response['error'] = 'Ошибка сохранения данных: ' . $e->getMessage();
            } catch (Exception $e) {
                $response['error'] = $e->getMessage();
            }
        } else {
            $response['error'] = 'Не удалось загрузить файл.';
        }
    } else {
        $response['error'] = 'Некорректные данные.';
    }
} else {
    $response['error'] = 'Неверный метод запроса.';
}

echo json_encode($response);
