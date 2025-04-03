<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create pin</title>

    <link rel="shortcut icon" href="../img/pin_icon.png" />
    <link rel="stylesheet" href="../css/main.css">



</head>

<script src="../js/uploadImage.js" defer></script>

<?php
require 'db.php';
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

            <div class="create-pin_con">
                <div class="create-new_text">
                    <div class="create-pin-text">Создание пина</div>
                    <div class="publish-btn">
                        <button type='submit' id="submit-button">Опубликовать</button>
                    </div>
                    
                </div>
                <div class="create-pin-menu">

                    <div class="upload-image_menu" >

                    
                        <input style="display: ;" type="file" name="file" id="file" class="input_file" accept="image/*" required >
                        <label style="display: ;" for="file" class="label_image" id="label_image">
                            <div class="label_discription">
                                <div class="label_disc_1">
                                    <div class="lebel_disc_1_pic">
                                        <img src="../img/arrow_top.png" alt="">
                                    </div>
                                    <div class="lebel_disc_1_text">Выберите файл</div>
                                </div>
                                <div class="label_disc_2">
                                    <div class="label_disc_2_text">
                                    Рекомендауем использовать файлы высокого разрешения в формате .png (меньше 20Мб)
                                    </div>
                                </div>
                            </div>
                        </label>




                        <div   style="display: none ;" id="image_container" class="image_container" >
                            <img src="" alt="" class="insert_image_create_pin" id="insert_image_create_pin">
                        </div>




                    </div>


                    <div class="form_item-con">
                        <form action="" class='register_form' id='create-new-pin-form'>
                            <h4>Название</h4>
                            <input type="text" class='input_line create-pin-input' id='photo_title' name='photo_title'>
                            <h4>Описание</h4>
                            <textarea type="text" class='input_line create-pin-input' id='photo_description' name='photo_description'></textarea>
                            <h4>Тег (укажите теги через пробел)</h4>
                            <input type="text" class='input_line create-pin-input' id='photo_tag' name='photo_tag'>
                        </form>
                    </div>
                </div>
                
            </div>












        </div>
    </div>
</body>
<script src="../js/onclick.js"></script>
<script src="../js/add_photo.js"></script>
</html>
    