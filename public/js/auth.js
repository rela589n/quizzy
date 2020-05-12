$(function () {
    let $showHidePasswordBlocks = $("[data-password-showable]");

    $showHidePasswordBlocks.each(function(indx, el) {
        let $el = $(el);
        let $inp = $el.find('input[type=password]');

        let $link = $el.find($el.attr('data-password-link-selector'));
        let $icon = $el.find($el.attr('data-password-icon-selector'));

        $link.on('click', function (event) {
            event.preventDefault();

            switch ($inp.attr("type")) {
                case 'text':
                    $inp.attr('type', 'password');
                    break;

                case 'password':
                    $inp.attr('type', 'text');
                    break;

                default:
                    return;
            }

            $icon.toggleClass("fa-eye");
            $icon.toggleClass("fa-eye-slash");
        });
    });
});
