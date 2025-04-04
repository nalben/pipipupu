<?php
require "db.php";
session_start();

if (!isset($_SESSION["user_id"])) {
    echo json_encode(["success" => false, "error" => "Не авторизован"]);
    exit;
}

$subscriber_id = $_SESSION["user_id"];
$author_id = isset($_POST["author_id"]) ? intval($_POST["author_id"]) : 0;

if ($subscriber_id === $author_id || $author_id === 0) {
    echo json_encode(["success" => false, "error" => "Неверные данные"]);
    exit;
}

// Проверяем, есть ли подписка
$stmt = $pdo->prepare("SELECT COUNT(*) FROM subscribers WHERE subscriber_id = ? AND author_id = ?");
$stmt->execute([$subscriber_id, $author_id]);
$isSubscribed = $stmt->fetchColumn() > 0;

if ($isSubscribed) {
    // Удаляем подписку
    $stmt = $pdo->prepare("DELETE FROM subscribers WHERE subscriber_id = ? AND author_id = ?");
    $stmt->execute([$subscriber_id, $author_id]);
} else {
    // Добавляем подписку
    $stmt = $pdo->prepare("INSERT INTO subscribers (subscriber_id, author_id) VALUES (?, ?)");
    $stmt->execute([$subscriber_id, $author_id]);
}

// Получаем обновлённое количество подписчиков
$stmt = $pdo->prepare("SELECT COUNT(*) FROM subscribers WHERE author_id = ?");
$stmt->execute([$author_id]);
$subscribersCount = $stmt->fetchColumn();

echo json_encode([
    "success" => true,
    "isSubscribed" => !$isSubscribed,
    "subscribersCount" => $subscribersCount
]);
?>
