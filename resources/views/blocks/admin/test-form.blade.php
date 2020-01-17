<form action="" method="post" class="auth text-dark">
    <label for="name" class="form-info mb-3 h3">
        Введіть назву теста:
    </label>
    <input id="name" type="text" class="form-control" placeholder="Назва" required="required">

    <label for="time" class="form-info mb-3 h3">
        Введіть час (у хвилинах) для проходження теста:
    </label>
    <input id="time" type="number" class="form-control" placeholder="25" required="required" min="1" max="120">

    <label for="include" class="form-info mb-2 h3">
        Включити питання з наступних тестів:
    </label>
    <div class="form-row align-items-center flex-nowrap justify-content-start" data-variant="3">
        <div class="col-auto">
            <div class="form-check ">
                <div class="d-inline-block"></div>
                <input class="form-check-input mt-2 is-correct" type="checkbox" id="t[123][include]">
            </div>
        </div>
        <div class="col-form-label">
            <label for="t[123][include]" class="form-check-label variant-text">
                Об'єктно орієнтоване програмування
            </label>
        </div>
        <div class="col-2">
            <input id="t[123][count]" type="number" class="form-control form-control-sm" placeholder="25" required="required" min="1" max="120">
        </div>
    </div>

    <div class="form-row align-items-center flex-nowrap justify-content-start" data-variant="3">
        <div class="col-auto">
            <div class="form-check ">
                <div class="d-inline-block"></div>
                <input class="form-check-input mt-2 is-correct" type="checkbox" id="t[124][include]" name="t[124][include]">
            </div>
        </div>
        <div class="col-form-label">
            <label for="t[124][include]" class="form-check-label variant-text">
                Алгоритми
            </label>
        </div>
        <div class="col-2">
            <input id="t[124][count]" name="t[124][count]" type="number" class="form-control form-control-sm" placeholder="25" required="required" min="1" max="120">
        </div>
    </div>

    <button type="submit" class="btn btn-primary btn-block finish-test-btn mb-4 mt-4">{{ $submitButtonText ?? 'Зберегти' }}</button>
</form>
