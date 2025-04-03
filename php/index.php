<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Piny</title>

    <link rel="shortcut icon" href="../img/pin_icon.png" />
    <link rel="stylesheet" href="../css/main.css">



</head>
<body>


<script src="../js/ajax.js" defer></script>
<script src="../js/ajax2.js" defer></script>


<?php

require 'auth_check.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Обрабатываем данные формы и заботимся о безопасности
    header('Location: /pin/php/index.php'); // Выходим из "опасной зоны"
    exit;
}

?>



    <div class="main_page_con" id="reg_page_main_page">



        
        <div class="top_menu" id="login_page_top_menu">
            <div class="reg_img_logo">
                <img src="../img/pin_icon.png" alt="">
            </div>
            <div class="search_panel" id="reg_page_search">
                <img src="../img/search_icon.png" alt="">
                <input class="search" type="search" placeholder="Поиск по запросу">
            </div>



            <div class="profile">
                
                <div class="profile_button"><img id="prof_pic" src="../img/profile_pic.png" alt=""></div>
                <div class="profile_arrow"><img id="prof_arrow" src="../img/down_arrow_icon.png" alt=""></div>
            </div>
        </div>









        <div class="reg_log_con">



            <div class="login_con">
                <div class="welcome">

                    <img src="../img/pin_icon.png" alt="">
                    <h1>Есть аккаунт? <br>Войдите в Piny</h1>
                    <div class="h4_con_reg">
                        <h4>Находите новые идеи для </h4>
                        <h4>вдохновения</h4>
                    </div>






                    <form action="" method="POST" class="register_form" id="register_form">
                        <h4>Логин</h4>
                        <input 
                            type="text" 
                            name="login" 
                            placeholder="Введите логин" 
                            id="login" 
                            class="input_line" 
                            value="" 
                            required>
                        
                        
                        <h4>Пароль</h4>
                        <input 
                            type="password" 
                            name="password" 
                            placeholder="Введите пароль" 
                            id="password" 
                            class="input_line" 
                            required>
                        

                        <br>
                        <button type="submit" class="next_reg">Продолжить</button>
                    </form>






                    <h5>Продолжая, вы принимаете <u>Условия представления услуг Piny</u> и подтверждаете, что ознакомились с нашей <u>Политикой конфиденциальности.</u> </h5>

                </div>
            </div>
            <div style="border-left: 1px solid #000; height: 500px;"></div>
            <div class="register_con">
                <div class="welcome">

                    <img src="../img/pin_icon.png" alt="">
                    <h1>Впервые у нас? <br> Зарегистрируйтесь в Piny</h1>
                    <div class="h4_con_reg">
                        <h4>Находите новые идеи для </h4>
                        <h4>вдохновения</h4>
                    </div>




                    <form action="" method="POST" id="register_form1">
                        <h4>Логин</h4>
                        <input type="text" id="login1" name="login1" placeholder="Создайте логин" class="input_line" required>
                        <h4>Пароль</h4>
                        <input type="password" id="password1" name="password1" placeholder="Создайте пароль" class="input_line" required><br>
                        <h4>Никнейм</h4>
                        <input type="text" id="username1" name="username1" placeholder="Создайте никнейм" class="input_line" required><br>
                        <button type="submit" class="next_reg">Зарегистрироваться</button>
                    </form>






                    <h5>Продолжая, вы принимаете <u>Условия представления услуг Piny</u> и подтверждаете, что ознакомились с нашей <u>Политикой конфиденциальности.</u> </h5>

                </div>
            </div>



        </div>




    </div>
    
</body>