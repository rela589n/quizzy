$(function() {
    let $form = $('.form-clearable');
    let $formInputs = $form.find('input');
    let $formSelects = $form.find('select');

    $('button:reset').click(function(e) {
        e.preventDefault();
        $formInputs.val('');

        $formSelects.val("");
    })
});
