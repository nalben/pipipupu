<?php
$host = 'localhost';        // Сервер базы данных
$dbname = 'piny';      // Имя базы данных
$username = 'root';         // Имя пользователя (по умолчанию root)
$password = '';             // Пароль (по умолчанию пустой)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Ошибка подключения: " . $e->getMessage());
}
?>
