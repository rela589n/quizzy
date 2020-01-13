$(function () {
    $("#show_hide_password a").on('click', function (event) {
        event.preventDefault();
        let $passwordContainer = $('#show_hide_password');
        let $inp = $passwordContainer.find('input');
        let $icon = $passwordContainer.find('i');

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
