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

    let $assessmentTableWrapper = $('.assessment-table-wrapper');

    $('#mark_evaluator_type').change(function (e) {
        if ($(this).val() === 'custom') {
            $assessmentTableWrapper.find('input').prop('disabled', false);
            $assessmentTableWrapper.slideDown(500);

        } else {
            $assessmentTableWrapper.slideUp(500, function () {
                $assessmentTableWrapper.find('input').prop('disabled', true);
            });
        }
    }).change();

    let $assessmentTable = $assessmentTableWrapper.find('.assignmentTable');
    let $tableBody = $assessmentTable.children('tbody');

    $assessmentTable.find('.add-row-button').click(function () {
        let counter = nextId();

        let $prevRow = $tableBody.children(':last');
        let $prevMark = $prevRow.find('.map-mark-input');

        let prevMark = +$prevMark.val() || 2;

        var newRow = $(`<tr data-counter='${counter}'>`);
        var cols = "";

        cols += `<td class="col-1">
                            <input type="number" min="1" max="100"
                                   name="correlation_table[${counter}][mark]"
                                   value="${prevMark + 1}"
                                   class="form-control form-control-sm map-mark-input"
                                   required="required"/>
                        </td>`;

        cols += `<td class="col-1">
                            <input type="number" min="0" max="100" step=".01"
                                   name="correlation_table[${counter}][percent]"
                                   value=""
                                   class="form-control form-control-sm"
                                   title="Введіть кількість відсотків, скільки повинен набрати студент на відповідну оцінку"
                                   required="required"/>
                        </td>`;

        cols += `<td class="col-1">
                    <button type="button" class="btn btn-sm btn-danger mt-1 position-absolute delete-row-button" tabindex="-1">
                        <i class="fas fa-backspace"></i>
                    </button>
                </td>`;

        newRow.append(cols);
        $assessmentTable.append(newRow);
    });

    $("table.order-list").on("click", ".delete-row-button", function (event) {
        let toRemove = $(this).closest("tr");
        toRemove.remove();
    });

    function nextId() {
        if (typeof this.counter === 'undefined') {
            this.counter = randInt(1, 9999999);
        }

        return ++this.counter;
    }

    function randInt(minV, maxV) {
        return Math.floor(Math.random() * (+maxV - +minV) + +minV);
    }
});
