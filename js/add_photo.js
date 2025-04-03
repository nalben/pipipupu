// Обработчик для кнопки отправки вне формы
document.querySelector('#submit-button').addEventListener('click', () => {
    const form = document.querySelector('#create-new-pin-form'); // Получаем форму
    if (form) {
        form.requestSubmit(); // Инициируем отправку формы
    } else {
        console.error('Форма не найдена!');
    }
});

// Основная логика обработки формы
document.querySelector('#create-new-pin-form').addEventListener('submit', async (event) => {
    event.preventDefault(); // Отменяем стандартное поведение формы

    const title = document.querySelector('#photo_title').value.trim();
    const description = document.querySelector('#photo_description').value.trim();
    const tags = document.querySelector('#photo_tag').value.trim().split(' ').filter(tag => tag); // Убираем пустые теги
    const fileInput = document.querySelector('#file');
    const file = fileInput.files[0];

    // Проверяем, заполнены ли обязательные поля
    if (!title || !file) {
        alert('Название и файл обязательны для заполнения.');
        return;
    }

    const formData = new FormData();
    formData.append('photo_title', title);
    formData.append('photo_description', description); // Можно оставить пустым
    formData.append('photo_tag', JSON.stringify(tags)); // Можно оставить пустым
    formData.append('file', file);

    try {
        const response = await fetch('add_photo.php', {
            method: 'POST',
            body: formData,
        });

        const result = await response.json();
        if (result.success) {
            window.location.reload(); // Перезагружаем страницу
        } else {
            alert('Ошибка: ' + (result.error || 'Неизвестная ошибка.'));
        }
    } catch (error) {
        console.error('Ошибка при отправке запроса:', error);
        alert('Не удалось добавить фото.');
    }
});
