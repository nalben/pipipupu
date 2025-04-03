document.getElementById('register_form').addEventListener('submit', async function (e) {
    e.preventDefault(); // Отключаем стандартное поведение формы

    // Получаем данные из формы
    const login = document.getElementById('login').value;
    const password = document.getElementById('password').value;

    // Отправляем запрос на сервер
    try {
        const response = await fetch('auth_handler.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ login, password }) // Форматируем данные
        });

        const result = await response.json(); // Получаем JSON-ответ от сервера

        // Очистка предыдущих ошибок
        document.getElementById('login').classList.remove('error');
        document.getElementById('password').classList.remove('error');

        if (result.success) {
            // Успешный логин
            window.location.href = '/pin/php/main.php'; // Перенаправляем на главную страницу
        } else {
            // Отображаем ошибки
            if (result.errors.login) {
                document.getElementById('login').classList.add('error');
                document.getElementById('password').classList.add('error');
            }
            if (result.errors.password) {
                document.getElementById('password').classList.add('error');
                document.getElementById('login').classList.add('error');
            }
        }
    } catch (error) {
        console.error('Ошибка:', error); // Логируем возможные ошибки сети
    }
});