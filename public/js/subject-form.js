$(document).ready(function () {
    let $textContainer = $("<div/>");

    let translitParams = {
        caseType: 'lower',
        replaceSpaces: '-'
    };

    let $generateTranslit = $('#auto-generate-translit');

    $('#alias').liTranslit(translitParams);

    $('#name').on('input', function () {
        if ($(this).val().trim() !== '') {
            $generateTranslit.removeAttr('disabled');
        }
        else {
            $generateTranslit.attr('disabled', 'disabled');
        }
    }).liTranslit({...translitParams, elAlias: $textContainer});

    $generateTranslit.click(function () {
        $('#alias').val($textContainer.text());
    });
});
