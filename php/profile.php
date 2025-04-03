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






                <div class="profile_card">

                    <div class="profile_img"><img src="../img/standart_avatar.jpg" alt=""></div>
                    <div class="user_name">NALBEN</div>
                    <div class="follow">
                        <div class="subscriptions"><i>1</i> подписка</div>
                        <div class="subscribers"><i>12</i> подписчиков</div>
                    </div>
                    <button class="sub_button " type='submit' id='subscribe_btn'>Подписаться</button>
                    <div class="if_own">
                        <button class='sub_button'>Поделиться</button>
                        <button class='sub_button'>Изменить профиль</button>
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




                    <div class="own_pins profile_content">

                    </div>
                </div>
            </div>
            <div class="cards_block profile_content own_pins" id="createdContent">



            <?php

try {
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
    ");
    $stmt->execute();

    $photos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($photos) {
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
    } else {
        echo "";
    }
} catch (PDOException $e) {
    echo "";
}
?>



            
            
        </div>
    </div>
    <script src='../js/stack_img_profile.js'></script>
    <script src="../js/toggle_profile.js"></script>
    <script src="../js/onclick.js"></script>
    <script src="../js/masonary.js"></script>
    <script src="../js/setMasonary.js"></script>
</body>
</html>