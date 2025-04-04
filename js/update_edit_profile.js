document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("edit_profile_modal");
    const saveBtn = document.getElementById("confirm_button_edit");
    const avatarInput = document.createElement("input");
    avatarInput.type = "file";
    avatarInput.accept = "image/*";

    const avatarImg = document.getElementById("edit_avatar_img");
    const avatarBtn = document.getElementById("edit_avatar_button");

    avatarBtn.addEventListener("click", function () {
        avatarInput.click();
    });

    avatarInput.addEventListener("change", function () {
        if (avatarInput.files.length > 0) {
            const file = avatarInput.files[0];
            const reader = new FileReader();

            reader.onload = function (e) {
                avatarImg.src = e.target.result;
            };

            reader.readAsDataURL(file);
        }
    });

    saveBtn.addEventListener("click", async function (e) {
    e.preventDefault(); // не даём форме сабмитнуться стандартно

    const oldPass = document.getElementById("old_pass").value.trim();
    const newPass = document.getElementById("new_pass").value.trim();
    const newNickname = document.getElementById("new_nickname").value.trim();

    // ⛔ Проверка: если один из паролей заполнен, а другой нет — ошибка
    const onlyOnePasswordFilled = (oldPass && !newPass) || (!oldPass && newPass);
    if (onlyOnePasswordFilled) {
        showCustomNotification("Заполните оба поля для смены пароля!", true);
        return;
    }

    const formData = new FormData();
    if (oldPass && newPass) {
        formData.append("old_pass", oldPass);
        formData.append("new_pass", newPass);
    }
    if (newNickname) {
        formData.append("new_nickname", newNickname);
    }
    if (avatarInput.files.length > 0) {
        formData.append("avatar", avatarInput.files[0]);
    }

    try {
        const response = await fetch("update_profile.php", {
            method: "POST",
            body: formData
        });

        const responseText = await response.text();
        console.log("Ответ от сервера:", responseText);

        try {
            const result = JSON.parse(responseText);
            if (result.success) {
                showCustomNotification("Данные обновлены!");
                window.location.reload();
            } else {
                showCustomNotification(result.error || "Ошибка обновления.", true);
            }
        } catch (error) {
            console.error("Ошибка при разборе JSON:", error);
            showCustomNotification("Ошибка ответа от сервера.", true);
        }
    } catch (error) {
        console.error("Ошибка при отправке запроса:", error);
        showCustomNotification("Ошибка при отправке запроса.", true);
    }
});

    // Функция для отображения кастомного уведомления
    function showCustomNotification(message, isError = false) {
    const notification = document.createElement('div');
    notification.className = 'notification';
    notification.textContent = message;

    if (isError) {
        notification.classList.add('error');
    }

    const modal = document.getElementById("error_con_edit");
    modal.appendChild(notification); // 👈 Добавляем в модалку

    setTimeout(() => {
        notification.remove();
    }, 5000);
}
});



