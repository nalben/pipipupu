<?php
session_start();
header('Content-Type: application/json');
require 'db.php';

$response = ["success" => false];

if (!isset($_SESSION["user_id"])) {
    $response["error"] = "Пользователь не авторизован";
    echo json_encode($response);
    exit;
}

$user_id = $_SESSION["user_id"];

// Получаем текущие данные пользователя
$stmt = $pdo->prepare("SELECT password, avatar FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    $response["error"] = "Пользователь не найден";
    echo json_encode($response);
    exit;
}

// Обновляем пароль, если предоставлены старый и новый пароли
if (!empty($_POST["old_pass"]) && !empty($_POST["new_pass"])) {
    // Сравниваем введенный старый пароль с хешем в базе данных
    if (!password_verify($_POST["old_pass"], $user["password"])) {
        $response["error"] = "Старый пароль неверен";
        echo json_encode($response);
        exit;
    }

    // Хешируем новый пароль
    $new_password = password_hash($_POST["new_pass"], PASSWORD_DEFAULT);

    // Обновляем пароль в базе данных
    $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE user_id = ?");
    $stmt->execute([$new_password, $user_id]);
}








// Обновляем никнейм
if (!empty($_POST["new_nickname"])) {
    $stmt = $pdo->prepare("UPDATE users SET username = ? WHERE user_id = ?");
    $stmt->execute([$_POST["new_nickname"], $user_id]);
    $_SESSION["username"] = $_POST["new_nickname"];
}

// Обновляем аватар
if (!empty($_FILES["avatar"]["name"])) {
    // Путь к папке uploads (в той же директории, что и текущий скрипт)
    $uploadDir = "uploads/";

    // Если папка не существует, создаем её
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Создаём папку с правами на запись
    }

    // Формируем имя файла
    $fileExtension = pathinfo($_FILES["avatar"]["name"], PATHINFO_EXTENSION);
    $fileName = "avatar_" . $user_id . "_" . time() . "." . $fileExtension;
    $uploadPath = $uploadDir . $fileName;

    // Перемещаем файл
    if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $uploadPath)) {
        // Обновляем путь к аватару в БД с учетом папки 'uploads/'
        $stmt = $pdo->prepare("UPDATE users SET avatar = ? WHERE user_id = ?");
        $stmt->execute([$uploadDir . $fileName, $user_id]);

        // Удаляем старый аватар (если он не стандартный)
        if ($user["avatar"] !== "standart_avatar.jpg") {
            @unlink($uploadDir . $user["avatar"]);
        }

        $_SESSION["avatar"] = $uploadDir . $fileName;
    } else {
        $response["error"] = "Ошибка загрузки файла";
        echo json_encode($response);
        exit;
    }
}

$response["success"] = true;
echo json_encode($response);
?>
