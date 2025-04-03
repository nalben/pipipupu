<?php
session_start();

// Проверяем, авторизован ли пользователь
if (!isset($_SESSION['user_id'])) {
    // Если пользователь не авторизован и находится не на index.php, перенаправляем его на index.php
    if (basename($_SERVER['PHP_SELF']) !== 'index.php') {
        header('Location: index.php');
        exit;
    }
} else {
    // Если пользователь авторизован и находится на index.php, перенаправляем его на main.php
    if (basename($_SERVER['PHP_SELF']) === 'index.php') {
        header('Location: main.php');
        exit;
    }
}
?>
