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

    <div class="site_con">
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



            

            
            <div class="cards_block" id="card_block_main">



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
    </div>
    <script src="../js/onclick.js"></script>
    <script src="../js/masonary.js"></script>
</body>
</html>