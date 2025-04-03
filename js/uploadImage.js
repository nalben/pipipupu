document.getElementById('file').addEventListener('change', function (event) {
    const file = event.target.files[0]; // Получаем выбранный файл

    if (file) {
        const reader = new FileReader(); // Создаем FileReader для чтения файла
        reader.onload = function (e) {
            // Скрываем лейбл
            document.getElementById('label_image').style.display = 'none';

            // Отображаем контейнер с картинкой
            const imageContainer = document.getElementById('image_container');
            const img = document.getElementById('insert_image_create_pin');
            img.src = e.target.result; // Устанавливаем путь к загруженному изображению
            imageContainer.style.display = 'block'; // Показываем контейнер
        };
        reader.readAsDataURL(file); // Читаем файл как Data URL
    }
});
