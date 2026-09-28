(function ($) {
    $(".item-quantity").on("change", function (e) {
        let id = $(this).data("id");
        $.ajax({
            url: "/cart/" + id,
            method: "put",
            data: {
                quantity: $(this).val(),
                _token: csrf_token,
            },
        });
    });

    $(".remove-item").on("click", function (e) {
        let id = $(this).data("id");
        $.ajax({
            url: "/cart/" + id,
            method: "delete",
            data: {
                _token: csrf_token,
            },
            success: (response) => {
                $(`#${id}`).remove();
            },
        });
    });
})(jQuery);
