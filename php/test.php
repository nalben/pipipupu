<?php
$password = "ebegin80"; // Введённый пароль
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    echo "$hashedPassword";
