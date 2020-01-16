$(document).ready(function () {
    let $textContainer = $("<div/>");

    let translitParams = {
        caseType: 'lower',
        replaceSpaces: '-'
    };

    let $generateTranslit = $('#auto-generate-translit');

    $('#alias').liTranslit(translitParams);

    $('#name').change(function () {
        console.log("changed");
        if ($(this).val().trim() !== '') {
            $generateTranslit.removeAttr('disabled');
        }
    }).liTranslit({...translitParams, elAlias: $textContainer});

    $generateTranslit.click(function () {
        $('#alias').val($textContainer.text());
    });
});
