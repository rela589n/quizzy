@extends('layouts.categories-single', [
    'mainContainerType' => 'container-fluid',
    'baseLayout' => 'layouts.root.client',
    'contentColumns' => 12
    ])

@section('title')
    Результати {{ $authUser->name }}
@endsection

{{--@section('content')--}}
{{--    {{ Breadcrumbs::render('admin.results.subject.test', $test, $subject) }}--}}
{{--    @parent--}}
{{--@endsection--}}

@php
    /** @var $testResult \App\Models\TestResult */
@endphp

@section('category-header-text') {{ $authUser->name }}, ваші результати: @endsection

@section('category-main-content')
    <form method="get" class="form-clearable submit-only-filled text-light">
        <table class="table table-responsive-lg table-bordered table-hover table-dark test-results-table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Предмет</th>
                <th scope="col">Тест</th>
                <th scope="col">Результат, %</th>
                <th scope="col">Оцінка</th>
                <th scope="col">Дата</th>
            </tr>
            </thead>
            <tbody>

            @forelse($testResults as $testResult)
                <tr>
                    <th scope="row">
                        @if($authUser->can('generate-student-statement'))
                            <a class="badge badge-primary"
                               href="{{ route('admin.results.subject.test.statements.student', [
                                        'subject' => $subject->uri_alias,
                                        'test' => $test->uri_alias,
                                        'testResultId' => $testResult->id
                                    ]) }}"
                               title="Натисніть, щоб генерувати відомість">{{ $testResult->id }}</a>
                        @else
                            {{ $testResult->id }}
                        @endif
                    </th>
                    <td>{{ $testResult->test->subject->name }}</td>
                    <td>{{ $testResult->test->name }}</td>
                    <td>{{ $testResult->result_percents }}</td>
                    <td>{{ $testResult->mark_readable }}</td>
                    <td>{{ $testResult->date_readable }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">Не знайдено жодного результата</td>
                </tr>
            @endforelse

            </tbody>
            <tfoot>
            <tr class="table-active">
                <th class="input ui-state-default" rowspan="1" colspan="1">
                    <input name="resultId" id="resultId" value="{{ request('resultId') }}" type="number" min="1"
                           placeholder="id" title="id"
                           class="form-control form-control-sm table-input-extra-narrow @error('resultId') is-invalid @enderror">

                    @error('resultId')
                    <span class="invalid-feedback" role="alert"><label for="resultId">{{ $message }}</label></span>
                    @enderror
                </th>
                <th>
                    <input name="subjectName" id="subjectName" type="text" value="{{ request('subjectName') }}" min="0" max="100"
                           placeholder="Предмет" title="Предмет тестування"
                           class="form-control form-control-sm table-input-narrow @error('subjectName') is-invalid @enderror">

                    @error('subjectName')
                    <span class="invalid-feedback" role="alert"><label for="subjectName">{{ $message }}</label></span>
                    @enderror
                </th>
                <th>
                    <input name="testName" id="testName" type="text" value="{{ request('testName') }}" min="0" max="100"
                           placeholder="Тест" title="Пройдений Тест"
                           class="form-control form-control-sm table-input-narrow @error('testName') is-invalid @enderror">

                    @error('testName')
                    <span class="invalid-feedback" role="alert"><label for="testName">{{ $message }}</label></span>
                    @enderror
                </th>
                <th>
                    <input name="result" id="result" type="number" value="{{ request('result') }}" min="0" max="100"
                           step="0.1"
                           placeholder="Результат" title="Результат"
                           class="form-control form-control-sm table-input-narrow @error('result') is-invalid @enderror">

                    @error('result')
                    <span class="invalid-feedback" role="alert"><label for="result">{{ $message }}</label></span>
                    @enderror
                </th>
                <th>
                    <select name="mark" id="mark"
                            title="Оцінка"
                            class="form-control form-control-sm @error('mark') is-invalid @enderror">
                        <option value="">Всі</option>
                        @foreach ($possibleMarks as $mark)
                            <option value="{{ $mark }}" @if($mark == request('mark')) selected @endif>{{ $mark }}</option>
                        @endforeach
                    </select>

                    @error('mark')
                    <span class="invalid-feedback" role="alert"><label for="mark">{{ $message }}</label></span>
                    @enderror
                </th>
                <th>
                    <input name="resultDateIn" id="resultDateIn" type="text"
                           placeholder="Дата" title="Дата"
                           class="form-control form-control-sm table-input-middle @error('resultDateIn.*') is-invalid @enderror"
                           value="{{ request('resultDateIn') }}"
                           data-datepicker>

                    @error('resultDateIn.*')
                    <span class="invalid-feedback" role="alert"><label for="resultDateIn">{{ $message }}</label></span>
                    @enderror
                </th>
            </tr>
            <tr>
                <td colspan="8">
                    <div class="d-flex justify-content-between filter-buttons">
                        <div></div>
                        <div>
                            <button type="reset" class="btn btn-primary mr-3">Очистити фільтри</button>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i>Фільтрувати</button>
                        </div>
                    </div>
                </td>
            </tr>
            </tfoot>
        </table>
    </form>

    {{ $testResults->links() }}
@endsection

@section('head_styles')
    @parent
    <link rel="stylesheet" href="{{ asset('libs/bootstrap-selectpicker/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('bottom-scripts')
    @parent
    <script defer src="{{ asset('js/clear-form-fields.js') }}"></script>
    <script defer src="{{ asset('js/submit-only-filled.js') }}"></script>

    @include('blocks.scripts.bootstrap-datepicker')

    <script defer src="{{ asset('js/datepicker.js') }}"></script>
    <script defer src="{{ asset('js/pages/test-result.js') }}"></script>
@endsection
