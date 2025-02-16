
    // Функция для инициализации Masonry
    function initializeMasonry() {
        const cardsBlock = document.querySelector('.cards_block');

        if (!cardsBlock) return;

        // Получаем значение CSS-переменной --columns-count
        const computedStyle = getComputedStyle(cardsBlock);
        const columnsCount = parseInt(computedStyle.getPropertyValue('--columns-count')) || 1;

        // Рассчитываем ширину одной колонки
        const columnWidth = cardsBlock.offsetWidth / columnsCount;

        // Инициализация Masonry
        const masonry = new Masonry(cardsBlock, {
            itemSelector: '.card',
            columnWidth: columnWidth,
            gutter: 16, // Расстояние между элементами
        });

        return masonry;
    }

    // Инициализация при загрузке страницы
    document.addEventListener('DOMContentLoaded', () => {
        let masonryInstance = initializeMasonry();

        // Обновление Masonry при изменении размера окна
        window.addEventListener('resize', () => {
            if (masonryInstance) {
                masonryInstance.destroy(); // Уничтожаем текущую инстанцию
            }
            masonryInstance = initializeMasonry(); // Создаем новую
        });
    });
