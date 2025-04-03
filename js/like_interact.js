document.querySelectorAll('.like_interact').forEach((likeButton) => {
    likeButton.addEventListener('click', async (event) => {
        event.preventDefault(); // Отменяем стандартное поведение
        const photoId = likeButton.getAttribute('data-photo-id');
        const likeIcon = likeButton.querySelector('img');
        const likeCount = document.querySelector(`.like_count[data-photo-id="${photoId}"]`);

        try {
            const response = await fetch('like_handler.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ photo_id: photoId }),
            });

            const result = await response.json();

            if (result.success) {
                likeIcon.src = result.liked ? '../img/like2.png' : '../img/like.png';
                likeCount.textContent = result.like_count;
            } else {}
        } catch (error) {}
    });
});
