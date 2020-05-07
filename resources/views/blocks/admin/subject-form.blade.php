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

    <div class="row">
        <div class="col-12">
            <div class="form-group">

                <select class="selectpicker form-control dropup @error('courses.*') is-invalid @enderror"
                        data-dropup-auto="false" data-style="btn-outline-secondary selectpicker-button"
                        multiple="multiple"
                        title="Оберіть курс(и)" required="required"
                        id="courses" name="courses[]">

                    @php($subjectCourses = array_flip(old('courses', $subject->courses_numeric ?? [])))

                    @foreach($allCourses as $course)
                        <option value="{{ $course->id }}"
                                @if( array_key_exists("$course->id", $subjectCourses)) selected="selected" @endif>
                            {{ $course->public_name }}
                        </option>
                    @endforeach
                </select>
                @error('courses.*')
                <span class="invalid-feedback" role="alert"><label for="courses">{{ $message }}</label></span>
                @enderror
            </div>
        </div>
    </div>
    @component('blocks.admin.submit-button', ['columns' => $submitSize ?? 12])
        {{ $submitButtonText ?? 'Створити' }}
    @endcomponent
</form>

@section('head_styles')
    @parent
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
@endsection

@section('bottom-scripts')
    @parent
    @include('blocks.scripts.bootstrap-select')
@endsection
