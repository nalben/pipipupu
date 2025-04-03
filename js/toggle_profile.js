document.addEventListener("DOMContentLoaded", function () {
    const savedBtn = document.getElementById("savedBtn");
    const createdBtn = document.getElementById("createdBtn");
    const savedContent = document.getElementById("savedContent");
    const createdContent = document.getElementById("createdContent");

    const savedWrapper = savedBtn.parentElement;
    const createdWrapper = createdBtn.parentElement;

    function setMasonry() {
        if (typeof window.setMasonry === "function") {
            setTimeout(() => window.setMasonry(), 1000); // Ждём, пока браузер применит стили
        }
    }

    function toggleContent(activeBtn, inactiveBtn, activeContent, inactiveContent, activeWrapper, inactiveWrapper) {
        activeBtn.classList.add("1");
        inactiveBtn.classList.remove("1");

        activeContent.classList.add("active_profile");
        inactiveContent.classList.remove("active_profile");

        activeWrapper.classList.add("active_button_profile");
        inactiveWrapper.classList.remove("active_button_profile");

        setMasonry(); // Пересчёт Masonry при смене вкладки
    }

    // Устанавливаем начальное состояние
    toggleContent(savedBtn, createdBtn, savedContent, createdContent, savedWrapper, createdWrapper);

    savedBtn.addEventListener("click", function () {
        toggleContent(savedBtn, createdBtn, savedContent, createdContent, savedWrapper, createdWrapper);
    });

    createdBtn.addEventListener("click", function () {
        toggleContent(createdBtn, savedBtn, createdContent, savedContent, createdWrapper, savedWrapper);
    });
});
