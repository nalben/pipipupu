document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.board_img_con').forEach(container => {
        const images = container.querySelectorAll('img');

        if (images.length > 3) {
            container.classList.add('stacked');
        } else {
            container.classList.add('grid');
        }
    });
});
