$(document).ready(function () {
    let $textContainer = $("<div/>");

    let translitParams = {
        caseType: 'lower',
        replaceSpaces: '-'
    };
    $('#alias').liTranslit(translitParams);

    $('#name').liTranslit({...translitParams, elAlias: $textContainer});

    $('#auto-generate-translit').click(function () {
        $('#alias').val($textContainer.text());
    });
});
