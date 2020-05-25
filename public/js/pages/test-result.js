$(function () {
    let $submitGenerateStatementByFiltersButton = $('.generateGroupStatementByFilters');

    $submitGenerateStatementByFiltersButton.click(function () {
        let $form = $('.generateGroupStatementByFiltersForm');
        let $filtersForm = $(this).closest('form');

        $form.find('[name=resultId]').val($filtersForm.find('[name=resultId]').val());
        $form.find('[name=groupId]').val($filtersForm.find('[name=groupId]').val());
        $form.find('[name=surname]').val($filtersForm.find('[name=surname]').val());
        $form.find('[name=name]').val($filtersForm.find('[name=name]').val());
        $form.find('[name=patronymic]').val($filtersForm.find('[name=patronymic]').val());
        $form.find('[name=result]').val($filtersForm.find('[name=result]').val());
        $form.find('[name=mark]').val($filtersForm.find('[name=mark]').val());
        $form.find('[name=resultDateIn]').val($filtersForm.find('[name=resultDateIn]').val());

        $form.submit();
    });

    $('#groupId').change(function (e) {
        if ($(this).val()) {
            $submitGenerateStatementByFiltersButton.removeAttr('disabled');
        } else {
            $submitGenerateStatementByFiltersButton.attr('disabled', 'disabled');
        }
    }).change();
});
