$(function () {

    let $showHidePasswordBlock = $("[data-password-showable]");
    let $inp = $showHidePasswordBlock.find('input[type=password]');

    let $link = $showHidePasswordBlock.find($showHidePasswordBlock.attr('data-password-link-selector'));
    let $icon = $showHidePasswordBlock.find($showHidePasswordBlock.attr('data-password-icon-selector'));

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
