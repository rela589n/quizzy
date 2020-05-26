$(function () {
    $('.include-full-subject-button').click(function (e) {
        let $this = $(this);

        let collapseBtn = $this.siblings('[data-toggle=collapse]');
        let collapseBlock = $(collapseBtn.attr('data-target'));

        collapseBlock.collapse('show');

        setTimeout(function () {
            collapseBlock.find('input[type=checkbox]').prop('checked', true);
            collapseBlock.find('input[type=number]').val(999);
        }, 200);
    });
});
