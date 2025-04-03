function setMasonry() {
    const container = document.querySelector(".cards_block");
    if (!container) return; // Проверяем, есть ли контейнер, чтобы избежать ошибок

    const items = Array.from(container.children);
    const topMenu = document.querySelector(".top_menu"); // Блок, задающий ширину

    if (!topMenu) return; // Проверяем, есть ли topMenu

    const availableWidth = topMenu.offsetWidth; // Доступная ширина
    const gap = 16; // Отступы между карточками

    const baseCardWidth = 229.6; // Базовая ширина карточки
    let cardsPerRow = Math.floor(availableWidth / baseCardWidth); // Количество колонок
    if (cardsPerRow < 1) cardsPerRow = 1; // Минимум одна колонка

    const totalGap = ((cardsPerRow - 1) + 2) * gap; // Общий отступ
    const finalCardWidth = Math.floor((availableWidth - totalGap) / cardsPerRow);

    const columnHeights = Array(cardsPerRow).fill(0); // Массив высот колонок

    items.forEach((item) => {
        item.style.width = `${finalCardWidth}px`; // Устанавливаем ширину

        const minHeight = Math.min(...columnHeights);
        const columnIndex = columnHeights.indexOf(minHeight);

        item.style.position = "absolute";
        item.style.top = `${minHeight}px`;
        item.style.left = `${columnIndex * (finalCardWidth + gap)}px`;

        columnHeights[columnIndex] += item.offsetHeight + gap; // Обновляем высоту колонки
    });

    container.style.position = "relative";
    container.style.height = `${Math.max(...columnHeights)}px`; // Высота контейнера
}

// Делаем функцию доступной глобально
window.setMasonry = setMasonry;
