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

    @include('blocks.admin.uri-alias-field', ['aliasable' => $subject ?? null])

    <label for="courses" class="form-info mb-4 h3">
        Виберіть курс, на якому викладається предмет:
    </label>

    @php($subjectCourses = array_flip(old('courses', $subject->courses_numeric)))

    <select class="browser-default custom-select @error('courses.*') is-invalid @enderror" required="required" id="courses"
            name="courses[]">
        @foreach($allCourses as $course)
            <option value="{{ $course->id }}"
                    @if( array_key_exists("$course->id", $subjectCourses)) selected="selected" @endif>
                {{ $course->public_name }}
            </option>
        @endforeach
    </select>
    @error("courses.*")
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror

    @component('blocks.admin.submit-button', ['columns' => $submitSize ?? 12])
        {{ $submitButtonText ?? 'Створити' }}
    @endcomponent
</form>
