@extends('layouts.tests-transfer', ['baseLayout' => 'layouts.root.admin'])

@section('title')
    Імпорт {{ $subject->name }} - {{ $test->name }}
@endsection

@section('category-header-text')
    Імпорт {{ $subject->name }} - {{ $test->name }} з docx:
@endsection

@section('content')
    {{ Breadcrumbs::render('admin.tests.subject.test.transfer', $test, $subject) }}
    @parent
@endsection

@section('transfer-form-content')
    <div class="form-group form-row align-items-start">
        <label for="selected-file" class="form-info h4 m-0 col-3">
            Оберіть файл:
        </label>
        <div class="col-9">
            <input id="selected-file" name="selected-file"
                   class="form-control @error('selected-file') is-invalid @enderror"
                   type="file" required>

            @error('selected-file')
            <span class="invalid-feedback" role="alert">
                <label for="selected-file">{{ $message }}</label>
            </span>
            @enderror
        </div>
    </div>

    @component('blocks.admin.submit-button', ['columns' =>  12])
        Імпортувати
    @endcomponent
@endsection
