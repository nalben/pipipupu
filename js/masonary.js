document.addEventListener("DOMContentLoaded", function () {
    const container = document.querySelector(".cards_block");
    const items = Array.from(container.children);
    const topMenu = document.querySelector(".top_menu");

    function setMasonry() {
        if (!container || !items.length || !topMenu) return;

        const availableWidth = topMenu.offsetWidth;
        const gap = 16;
        const baseCardWidth = 229.6;
        let cardsPerRow = Math.max(1, Math.floor(availableWidth / baseCardWidth));

        const totalGap = (cardsPerRow - 1) * gap;
        const finalCardWidth = Math.floor((availableWidth - totalGap) / cardsPerRow);

        items.forEach((item) => {
            item.style.width = `${finalCardWidth}px`;
            item.style.position = "static";
        });

        setTimeout(() => {
            const columnHeights = Array(cardsPerRow).fill(0);

            items.forEach((item) => {
                const minHeight = Math.min(...columnHeights);
                const columnIndex = columnHeights.indexOf(minHeight);

                item.style.position = "absolute";
                item.style.top = `${minHeight}px`;
                item.style.left = `${columnIndex * (finalCardWidth + gap)}px`;

                columnHeights[columnIndex] += item.offsetHeight + gap;
            });

            container.style.position = "relative";
            container.style.height = `${Math.max(...columnHeights)}px`;
        },10);
    }

    // Ждём загрузки всех изображений перед построением
    function waitForImages() {
        const images = Array.from(container.querySelectorAll("img"));
        let loadedCount = 0;

        if (images.length === 0) {
            setMasonry();
            return;
        }

        images.forEach((img) => {
            if (img.complete) {
                loadedCount++;
            } else {
                img.addEventListener("load", () => {
                    loadedCount++;
                    if (loadedCount === images.length) setMasonry();
                });
                img.addEventListener("error", () => {
                    loadedCount++;
                    if (loadedCount === images.length) setMasonry();
                });
            }
        });

        // Если все изображения уже загружены
        if (loadedCount === images.length) setMasonry();
    }

    // Инициализация после загрузки всех изображений
    window.addEventListener("load", waitForImages);

    // Перерасчёт при изменении размера окна
    window.addEventListener("resize", setMasonry);
});
