$(function () {
    setTimeout(function () {
        $(window).blur(function (e) {
            history.back();
        });
    }, 1000);
});
