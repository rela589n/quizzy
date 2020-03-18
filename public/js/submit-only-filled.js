$(function () {
    $('.submit-only-filled').submit(function (e) {
        $(this)
            .find('input[name], select[name]')
            .filter(function () {
                return this.value.trim().length === 0;
            })
            .prop('disabled', true);
    });
});
