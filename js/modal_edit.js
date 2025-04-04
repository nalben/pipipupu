document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("edit_profile_modal");
    const editBtn = document.getElementById("edit_profile");

    if (!modal || !editBtn) return;

    // Открытие окна
    editBtn.addEventListener("click", function () {
        modal.style.display = "flex";
    });

    // Закрытие окна по клику вне контента
    modal.addEventListener("click", function (event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });
});
