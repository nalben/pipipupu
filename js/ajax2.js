document.getElementById('register_form1').addEventListener('submit', async function (e) {
    e.preventDefault(); // Отключаем стандартное поведение формы

    // Получаем данные из формы
    const login = document.getElementById('login1').value;
    const username = document.getElementById('username1').value;

    // Отправляем запрос на сервер
    try {
        const response = await fetch('auth_handler_reg.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ login1: login, username1: username }) // Форматируем данные
        });

        const result = await response.json(); // Получаем JSON-ответ от сервера

        // Очистка предыдущих ошибок
        document.getElementById('login1').classList.remove('error');
        document.getElementById('username1').classList.remove('error');

        if (result.success) {
            // Успешная регистрация
            window.location.href = '/pin/php/main.php'; // Перенаправляем на главную страницу
        } else {
            // Отображаем ошибки
            if (result.errors.login) {
                document.getElementById('login1').classList.add('error');
            }
            if (result.errors.username) {
                document.getElementById('username1').classList.add('error');
            }
        }
    } catch (error) {
        console.error('Ошибка:', error); // Логируем возможные ошибки сети
    }
});