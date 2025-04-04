document.addEventListener("DOMContentLoaded", function () {
    const subscribeBtn = document.getElementById("subscribe_btn");
    
    if (!subscribeBtn) return;

    subscribeBtn.addEventListener("click", function () {
        const authorId = this.dataset.userId;
        
        fetch("../php/subscribe.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `author_id=${authorId}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                subscribeBtn.classList.toggle("subscribed");
                subscribeBtn.textContent = data.isSubscribed ? "Отписаться" : "Подписаться";

                document.getElementById("subscribers_count").textContent = data.subscribersCount;
            }
        })
        .catch(error => console.error("Ошибка:", error));
    });
});
