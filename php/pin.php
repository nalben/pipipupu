<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>item</title>

    <link rel="shortcut icon" href="../img/pin_icon.png" />
    <link rel="stylesheet" href="../css/main.css">


</head>
<?php
require 'auth_check.php';
require 'db.php';

// Получаем ID фотографии из URL
if (!isset($_GET['photo_id']) || !is_numeric($_GET['photo_id'])) {
    header('Location: index.php');
}
$photo_id = (int)$_GET['photo_id'];

try {
    $stmt = $pdo->prepare("
        SELECT 
            photos.path AS photo_path,
            photos.title AS photo_title,
            photos.description AS photo_description,
            users.avatar AS author_avatar,
            users.username AS author_username,
            users.user_id AS author_id
        FROM 
            photos
        INNER JOIN 
            users
        ON 
            photos.author_id = users.user_id
        WHERE 
            photos.photo_id = ?
    ");
    $stmt->execute([$photo_id]);
    $photo = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$photo) {
        header('Location: index.php');
    }


    $likeStmt = $pdo->prepare("
        SELECT COUNT(*) AS like_count
        FROM likes
        WHERE photo_id = ?
    ");
    $likeStmt->execute([$photo_id]);
    $likeData = $likeStmt->fetch(PDO::FETCH_ASSOC);
    $like_count = $likeData['like_count'] ?? 0;
} catch (PDOException $e) {
    
}


$user_id = $_SESSION['user_id'] ?? null;
$photo_id = $_GET['photo_id'] ?? null;

if ($photo_id && $user_id) {
    $stmt = $pdo->prepare("SELECT id FROM likes WHERE user_id = ? AND photo_id = ?");
    $stmt->execute([$user_id, $photo_id]);
    $liked = $stmt->fetch() ? true : false;
} else {
    $liked = false;
}
?>

<script src="../js/masonary.js"></script>
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
    



            <div class="item_big_card_con">
                <div class="arrow_back_con">
                    <div class="arrow_back">
                        <div class="arrow_wrap">
                        <img src="../img/left-arrow.png" alt="">
                    </div>
                    </div>
                </div>




                <div class="image_con">
                    <div class="big_card">
                        <img src="../php/<?php echo htmlspecialchars($photo['photo_path']); ?>" alt="">
                    </div>

                <div class="right_image_menu">
                    <div class="interaction_menu">


                    <div class="int_icons like_interact" onselectstart="return false" onmousedown="return false" data-photo-id="<?php echo htmlspecialchars($photo_id); ?>">
                        <img 
                        src="<?php echo $liked ? '../img/like2.png' : '../img/like.png'; ?>" 
                        alt="" 
                        class="like-icon">
                    </div>

                        <div class="like_count" data-photo-id="<?php echo $photo_id; ?>">
                            <?php echo $like_count; ?>
                        </div>

                        <div class="int_icons more_interact" onselectstart="return false" onmousedown="return false">
                            <img src="../img/more.png" alt="">
                        </div>


                        <div class="add_to_folder">
                            <div class="choose_folder"><span>folder name</span></div>
                            <div class="save_folder button_save"><button>Сохранить</button></div>
                        </div>
                    </div>

                    <div class="title_image marl_img_menu">
                        <p><?php echo htmlspecialchars($photo['photo_title']); ?></p>
                    </div>

                    <div class='author marl_img_menu '>
                        <div class='author_icon onclick'>
                            <img src="<?php echo $photo['author_avatar'] ? htmlspecialchars($photo['author_avatar']) : '../img/standart_avatar.jpg'; ?>" alt="">
                            <a href="profile.php?user_id=<?php echo $photo['author_id']; ?>">
                                <?php echo htmlspecialchars($photo['author_username']); ?>
                            </a>
                        </div>
                    </div>

                    <div class="discription_image marl_img_menu ">
                        <p><?php echo htmlspecialchars($photo['photo_description']); ?></p>
                    </div>

                    <div class="comments_image marl_img_menu ">

                    </div>
                </div>
            </div>

            </div>
            




            <div class="cards_block">

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
                    ;
                }
            } catch (PDOException $e) {
                
            }
            ?>
                

    </div>










    <script src="../js/onclick.js"></script>
    <script src="../js/like_interact.js"></script>
</body>