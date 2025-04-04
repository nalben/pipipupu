<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>piny</title>

    <link rel="shortcut icon" href="../img/pin_icon.png" />
    <link rel="stylesheet" href="../css/main.css">



</head>

<?php
require 'auth_check.php';
require 'db.php'
?>



<body>

    <div class="site_con" id='profile_con_scroll'>
        <div class="left_menu">
            <div class="onclick menu_item main_page"><a href="main.php"><img src="../img/pin_icon.png" alt=""></a></div>
            <div class="onclick menu_item create_new"><a href="create-pin.php"><img src="../img/plus_icon.png" alt=""></a></div>
            <div class="onclick menu_item notification"><a href="notification.html"><img src="../img/notification_icon.png" alt=""></a></div>
        </div>


    

        <div class="main_page_con">




            <div class="top_menu">
                <div class="search_panel">
                    <img src="../img/search_icon.png" alt="">
                    <input class="search" type="search" placeholder="Поиск по запросу">
                </div>



                <div class="profile">
                    
                    <div class="profile_button"><img id="prof_pic" src="../img/profile_pic.png" alt=""></div>
                    <div class="profile_arrow"><img id="prof_arrow" src="../img/down_arrow_icon.png" alt=""></div>
                </div>
            </div>





            <div class="profile_con">

                <div class="arrow_back_profile_page">
                        <img src="../img/left-arrow.png" alt="">
                </div>






                <?php

                $author_id = isset($_GET["user_id"]) ? intval($_GET["user_id"]) : 0;
                $subscriber_id = $_SESSION["user_id"] ?? 0;
                
                // Получаем данные автора
                $stmt = $pdo->prepare("SELECT username, avatar FROM users WHERE user_id = ?");
                $stmt->execute([$author_id]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                $username = $user["username"] ?? "Неизвестный";
                
                // Получаем аватар (если он существует)
                $avatar = !empty($user["avatar"]) ? $user["avatar"] : "../img/standart_avatar.jpg";
                
                // Количество подписчиков
                $stmt = $pdo->prepare("SELECT COUNT(*) FROM subscribers WHERE author_id = ?");
                $stmt->execute([$author_id]);
                $subscribersCount = $stmt->fetchColumn();
                
                // Количество подписок пользователя (на кого он подписан)
                $stmt = $pdo->prepare("SELECT COUNT(*) FROM subscribers WHERE subscriber_id = ?");
                $stmt->execute([$author_id]);
                $subscriptionsCount = $stmt->fetchColumn();
                
                // Проверяем, подписан ли текущий пользователь
                $stmt = $pdo->prepare("SELECT COUNT(*) FROM subscribers WHERE subscriber_id = ? AND author_id = ?");
                $stmt->execute([$subscriber_id, $author_id]);
                $isSubscribed = $stmt->fetchColumn() > 0;
                
                ?>

                    <div class="profile_card">
                        <div class="profile_img">
                            <!-- Используем аватар из базы данных или стандартный -->
                            <img src="<?= htmlspecialchars($avatar) ?>" alt="">
                        </div>

                        <div class="user_name"><?= htmlspecialchars($username) ?></div>

                        <div class="follow">
                            <div class="subscriptions"><i id="subscriptions_count"><?= $subscriptionsCount ?></i> подписка</div>
                            <div class="subscribers"><i id="subscribers_count"><?= $subscribersCount ?></i> подписчиков</div>
                        </div>

                        <?php if ($subscriber_id !== $author_id && $subscriber_id > 0) : ?>
                            <button class="sub_button <?= $isSubscribed ? 'subscribed' : '' ?>" 
                                    type="submit" 
                                    id="subscribe_btn" 
                                    data-user-id="<?= $author_id ?>">
                                <?= $isSubscribed ? "Отписаться" : "Подписаться" ?>
                            </button>
                        <?php elseif ($subscriber_id === $author_id) : ?>
                            <div class="if_own">
                                <button class='sub_button'>Поделиться</button>
                                <button class='sub_button' id='edit_profile'>Изменить профиль</button>
                            </div>
                        <?php endif; ?>
                    </div>



                
                <?php
                // Получаем данные текущего пользователя
                $user_id = $_SESSION["user_id"] ?? 0;

                $stmt = $pdo->prepare("SELECT avatar FROM users WHERE user_id = ?");
                $stmt->execute([$user_id]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                // Проверяем, если аватар существует, используем его, иначе стандартный
                $avatar = !empty($user["avatar"]) ? $user["avatar"] : "../img/standart_avatar.jpg";
                ?>

                <div class="modal" id="edit_profile_modal">
                    <div class="modal_content">
                        <h3>Изменение профиля</h3>
                        <p>Позаботьтесь о конфиденциальности личных данных. 
                            Добавляемая вами информация видна всем, кто 
                            может просматривать ваш профиль.</p>
                                        
                        <form id="edit_profile_form" enctype="multipart/form-data">
                            <p class='edit_input_p'>Изменить пароль</p>
                            <input type="password" class='input_line edit_profile_input_line' name="old_pass" placeholder='Введите старый пароль' id='old_pass'>
                            <input type="password" class='input_line edit_profile_input_line' name="new_pass" placeholder='Введите новый пароль' id='new_pass'>
                                        
                            <p class='edit_input_p'>Изменить Никнейм</p>
                            <input type="text" class='input_line edit_profile_input_line' name="new_nickname" placeholder='Введите новый никнейм' id='new_nickname'>
                                        
                            <div class="edit_avatar_con">
                                <img src="<?= htmlspecialchars($avatar) ?>" alt="Аватар пользователя" class='edit_avatar_img' id='edit_avatar_img'>
                                <input type="file" name="avatar" id="avatar_input" style="display: none;">
                                <button type="button" class='edit_avatar_button sub_button' id='edit_avatar_button'>Изменить</button>
                            </div>
                                        
                            <div class="confirm_button_edit_con">
                                <button type="submit" class='sub_button' id='confirm_button_edit'>Сохранить</button>
                            </div>
                            <div class="error_con_edit" id='error_con_edit'></div>
                        </form>
                    </div>
                </div>


                




                <div class="boards_con">
                    <div class="toggle">
                        <div class="btn_prof_wrap active_button_profile">
                            <button class="toggle_text" id="savedBtn">Сохраненные</button>
                        </div>
                        <div class="btn_prof_wrap">
                            <button class="toggle_text" id="createdBtn">Созданные</button>
                        </div>
                    </div>




                    <div class="boards profile_content active_profile" id="savedContent">



                    

                        <div class="board_item onclick">
                            <a href="">
                                <div class="board_img_con">
                                    <img src="../php/uploads/11.jpg" alt="">
                                    <img src="../php/uploads/12.jpg" alt="">
                                    <img src="../img/empty_background.jpg" alt="">
                               </div>
                           </a>
                           <div class="board_name">Дианочка</div>
                           <div class="board_count">5 пинов</div>
                        </div>

                        



                    </div>





                </div>
            </div>
            <div class="cards_block profile_content own_pins" id="createdContent">



                <?php

                try {
                    $user_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;
                    if ($user_id > 0) {
                        $stmt = $pdo->prepare("
                            SELECT 
                                photos.photo_id, 
                                photos.path AS photo_path, 
                                users.user_id, 
                                users.avatar AS user_avatar, 
                                users.username 
                            FROM 
                                photos 
                            INNER JOIN 
                                users 
                            ON 
                                photos.author_id = users.user_id
                            WHERE 
                                photos.author_id = :user_id
                        ");
                        $stmt->execute(['user_id' => $user_id]);
                    
                        $photos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                        foreach ($photos as $photo) {
                            $photoPath = "../php/" . htmlspecialchars($photo['photo_path']);
                            $userAvatar = $photo['user_avatar'] 
                                ? htmlspecialchars($photo['user_avatar']) 
                                : "../img/standart_avatar.jpg";
                            $userName = htmlspecialchars($photo['username']);
                            $photoId = htmlspecialchars($photo['photo_id']);
                            $userId = htmlspecialchars($photo['user_id']);
                        
                            echo "
                            <div class='card'>
                                <a href='pin.php?photo_id=$photoId'>
                                    <img src='$photoPath' alt=''>
                                </a>
                                <a href='profile.php?user_id=$userId'>
                                    <div class='author'>
                                        <div class='author_icon'>
                                            <img src='$userAvatar' alt=''>
                                            <a href='profile.php?user_id=$userId'>$userName</a>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            ";
                        }
                    }
                } catch (PDOException $e) {
                }
                ?>




            
            
            </div>
    </div>
    <script src='../js/stack_img_profile.js'></script>
    <script src="../js/toggle_profile.js"></script>
    <script src="../js/onclick.js"></script>
    <script src="../js/masonary.js"></script>
    <script src="../js/setMasonary.js"></script>
    <script src='../js/subscribe_ajax.js'></script>
    <script src='../js/modal_edit.js'></script>
    <script src='../js/update_edit_profile.js'></script>
</body>
</html>