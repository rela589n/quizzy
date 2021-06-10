$(function () {
    window.closeWhenSwitchedTabsConfigOnClose = window.closeWhenSwitchedTabsConfigOnClose || function () {
    };

    /** build config **/
    let config = {
        handleClose: function () {
            window.closeWhenSwitchedTabsConfigOnClose();
        }
    };

    setTimeout(function () {
        $(window).blur(function (e) {
            setTimeout(function() {
                if (document.hasFocus()) {
                    return;
                }

                config.handleClose();
            }, 1000);
        });
    }, 1000);
});
