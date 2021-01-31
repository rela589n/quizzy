$(function () {
    window.closeWhenSwitchedTabsConfigOnClose = window.closeWhenSwitchedTabsConfigOnClose || function () {
    };

    /** build config **/
    let config = {
        handleClose: function () {
            window.closeWhenSwitchedTabsConfigOnClose()
                .then(() => history.back());
        }
    };

    setTimeout(function () {
        $(window).blur(function (e) {
            config.handleClose();
        });
    }, 1000);
});
