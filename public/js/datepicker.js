$(function () {
    $('[data-datepicker]').datepicker({
        format: "dd.mm.yyyy",
        todayBtn: "linked",
        clearBtn: true,
        language: "uk",
        multidate: true,
        multidateSeparator: ", "
    });
});
