$(function () {
    $('.required-target').change(function() {
        let $this = $(this);

        let elementId = $this.attr('data-required');

        if (elementId === undefined) {
            console.error(`Element id is ${elementId}`);
        }

        let element = document.getElementById(elementId);

        if (element === null) {
            console.error(`Element with id '${elementId}' not found in DOM`);
            return;
        }

        element.required = this.checked;
    });
});
