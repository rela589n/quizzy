@extends('layouts.categories-single', [
    'mainContainerType' => 'container-fluid',
    'baseLayout' => 'layouts.root.admin',
    'contentColumns' => 12
    ])

@section('title')
    Результати {{ $subject->name }} - {{ $test->name }}
@endsection

@section('content')
    {{ Breadcrumbs::render('admin.results.subject.test', $test, $subject) }}
    @parent
@endsection

@section('category-header-text') {{ $subject->name }} - {{ $test->name }} результати: @endsection

@section('category-main-content')
    @if($authUser->can('generate-group-statement'))
        <form class="form-inline group-statements-form"
              action="{{ route('admin.results.subject.test.statements.group', [
                        'subject' => $subject->uri_alias,
                        'test' => $test->uri_alias,
                    ]) }}"
              method="get">
            <div class="form-group">
                <label for="statementGroupId">Відомість за групою: </label>

                <select name="groupId" id="statementGroupId" class="form-control form-control-sm mx-sm-3">
                    @foreach($userGroups as $group)
                        <option value="{{ $group->id }}"
                                @if($group->id == request('groupId')) selected @endif>{{ $group->name }}</option>
                    @endforeach
                </select>

                <button type="submit" class="btn btn-sm btn-primary">Генерувати</button>
            </div>
        </form>
    @endif

    <form method="get" class="form-clearable submit-only-filled">
        <table class="table table-responsive-lg table-bordered table-hover test-results-table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Група</th>
                <th scope="col">Прізвище</th>
                <th scope="col">Ім'я</th>
                <th scope="col">По-батькові</th>
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
                    <td>{{ $testResult->user->studentGroup->name }}</td>
                    <td>{{ $testResult->user->surname }}</td>
                    <td>{{ $testResult->user->name }}</td>
                    <td>{{ $testResult->user->patronymic }}</td>
                    <td>{{ $testResult->score_readable }}</td>
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
                    <select name="groupId" id="groupId"
                            title="Група"
                            class="form-control form-control-sm @error('groupId') is-invalid @enderror">
                        <option value="">Усі</option>
                        @foreach($userGroups as $group)
                            <option value="{{ $group->id }}"
                                    @if($group->id == request('groupId')) selected @endif>{{ $group->name }}</option>
                        @endforeach
                    </select>

                    @error('groupId')
                    <span class="invalid-feedback" role="alert"><label for="groupId">{{ $message }}</label></span>
                    @enderror
                </th>
                <th>
                    <input name="surname" id="surname" type="text" value="{{ request('surname') }}"
                           placeholder="Прізвище" title="Прізвище"
                           class="form-control form-control-sm table-input-middle @error('surname') is-invalid @enderror"
                    >
                    @error('surname')
                    <span class="invalid-feedback" role="alert"><label for="surname">{{ $message }}</label></span>
                    @enderror
                </th>
                <th>
                    <input name="name" id="name" type="text" value="{{ request('name') }}"
                           placeholder="Ім'я" title="Ім'я"
                           class="form-control form-control-sm table-input-middle @error('name') is-invalid @enderror"
                    >

                    @error('name')
                    <span class="invalid-feedback" role="alert"><label for="name">{{ $message }}</label></span>
                    @enderror
                </th>
                <th>
                    <input name="patronymic" id="patronymic" type="text" value="{{ request('patronymic') }}"
                           placeholder="По-батькові" title="По-батькові"
                           class="form-control form-control-sm table-input-middle @error('patronymic') is-invalid @enderror">

                    @error('patronymic')
                    <span class="invalid-feedback" role="alert"><label for="patronymic">{{ $message }}</label></span>
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
                        @foreach (range(1, 5) as $i)
                            <option value="{{ $i }}" @if($i == request('mark')) selected @endif>{{ $i }}</option>
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
                        <button type="reset" class="btn btn-primary">Очистити фільтри</button>
                        <button type="submit" class="btn btn-primary">Фільтрувати</button>
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
@endsection
