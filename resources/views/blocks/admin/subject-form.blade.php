<form method="post" class="auth text-dark">
    <label for="name" class="form-info mb-4 h3">
        Введіть назву предмета:
    </label>
    <input id="name" name="name" type="text" class="form-control" placeholder="Назва" required="required">

    <label for="alias" class="form-info mb-4 h3">
        Введіть псевдонім для використання в uri:
    </label>

    <div class="form-group form-row align-items-end">
        <div class="col-9">
            <input id="alias" name="alias" type="text" class="form-control" placeholder="Псевдонім"
                   required="required" value="">
        </div>
        <div class="col-3">
            <button type="button" id="auto-generate-translit" class="btn btn-primary btn-block"
                    disabled="disabled">Автоматично
            </button>
        </div>
    </div>

    <label for="course" class="form-info mb-4 h3">
        Виберіть курс, на якому викладається предмет:
    </label>
    <select class="browser-default custom-select" name="course" id="course" required="required">
        <option value="1">Перший</option>
        <option value="2">Другий</option>
        <option value="3">Третій</option>
        <option value="4">Четвертий</option>
    </select>

    <button type="submit" class="btn btn-primary btn-block finish-test-btn mt-4">{{ $submitButtonText ?? 'Створити' }}</button>
</form>
