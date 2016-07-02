$(".js-confirm-delete-comment").on("click", function (event) {
    if (!confirm('Are you sure you want to delete this comment?')) {
        event.preventDefault();
    }
});