$(function () {
    /** build config **/
    let config = {
        onClose: window.closeWhenSwitchedTabsConfigOnClose ||
            function () {
            }
    };

    setTimeout(function () {
        $(window).blur(function (e) {
            history.back();
            config.onClose();
        });
    }, 1000);
});
