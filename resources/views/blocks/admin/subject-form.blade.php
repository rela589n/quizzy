<form method="post" class="auth text-dark">
    @csrf
    <label for="name" class="form-info mb-4 h3">
        Введіть назву предмета:
    </label>
    <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Назва"
           required="required">

    @error('name')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror

    <label for="alias" class="form-info mb-4 h3">
        Введіть псевдонім для використання в uri:
    </label>

    <div class="form-group form-row align-items-start">
        <div class="col-9">
            <input id="alias" name="uri_alias" type="text" class="form-control @error('uri_alias') is-invalid @enderror" placeholder="Псевдонім"
                   required="required" value="">

            @error('uri_alias')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="col-3">
            <button tabindex="-1" type="button" id="auto-generate-translit" class="btn btn-primary btn-block"
                    disabled="disabled">Автоматично
            </button>
        </div>
    </div>

    <label for="course" class="form-info mb-4 h3">
        Виберіть курс, на якому викладається предмет:
    </label>
    <select class="browser-default custom-select @error('course') is-invalid @enderror" required="required" id="course" name="course">
        <option value="1">Перший</option>
        <option value="2">Другий</option>
        <option value="3">Третій</option>
        <option value="4">Четвертий</option>
    </select>

    @error('course')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror

    <button type="submit"
            class="btn btn-primary btn-block finish-test-btn mt-4">{{ $submitButtonText ?? 'Створити' }}</button>
</form>
