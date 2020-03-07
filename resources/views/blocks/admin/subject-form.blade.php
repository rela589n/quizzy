<form method="post" class="auth text-dark">
    @csrf
    <label for="name" class="form-info mb-4 h3">
        Введіть назву предмета:
    </label>
    <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Назва"
           required="required" value="{{  old('name',  $subject['name'] ?? '') }}">

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
            <input id="alias" name="uri_alias" type="text" class="form-control @error('uri_alias') is-invalid @enderror"
                   placeholder="Псевдонім"
                   required="required" value="{{ old('uri_alias', $subject['uri_alias'] ?? '') }}">

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

    @php
        $subjectCourse = old('course', $subject['course'] ?? '');
    @endphp
    <select class="browser-default custom-select @error('course') is-invalid @enderror" required="required" id="course"
            name="course">
        <option value="1" @if( $subjectCourse === '1') selected="selected" @endif>Перший</option>
        <option value="2" @if( $subjectCourse === '2') selected="selected" @endif>Другий</option>
        <option value="3" @if( $subjectCourse === '3') selected="selected" @endif>Третій</option>
        <option value="4" @if( $subjectCourse === '4') selected="selected" @endif>Четвертий</option>
    </select>

    @error('course')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror

    @component('blocks.admin.submit-button', ['columns' => $submitSize ?? 12])
        {{ $submitButtonText ?? 'Створити' }}
    @endcomponent
</form>
