@extends('layouts.categories-single', ['baseLayout' => 'layouts.root.admin', 'contentColumns' => 12])

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
        <table class="table table-bordered table-hover test-results-table">
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
                    <input name="resultId" value="{{ request('resultId') }}" type="number"
                           class="form-control form-control-sm table-input-extra-narrow" min="1" placeholder="id">
                </th>
                <th>
                    <select name="groupId" class="form-control form-control-sm">
                        <option value="">Усі</option>
                        @foreach($userGroups as $group)
                            <option value="{{ $group->id }}"
                                    @if($group->id == request('groupId')) selected @endif>{{ $group->name }}</option>
                        @endforeach
                    </select>
                </th>
                <th>
                    <input name="surname" type="text" value="{{ request('surname') }}"
                           class="form-control form-control-sm table-input-middle"
                           placeholder="Прізвище">
                </th>
                <th>
                    <input name="name" type="text" value="{{ request('name') }}"
                           class="form-control form-control-sm table-input-middle"
                           placeholder="Ім'я">
                </th>
                <th>
                    <input name="patronymic" type="text" value="{{ request('patronymic') }}"
                           class="form-control form-control-sm table-input-middle" placeholder="По-батькові">
                </th>
                <th>
                    <input name="result" type="number" value="{{ request('result') }}" min="0" max="100" step="0.1"
                           placeholder="Результат"
                           class="form-control form-control-sm table-input-narrow">
                </th>
                <th>
                    <select name="mark" class="form-control form-control-sm">
                        <option value="">Всі</option>
                        @foreach (range(1, 5) as $i)
                            <option value="{{ $i }}" @if($i == request('mark')) selected @endif>{{ $i }}</option>
                        @endforeach
                    </select>
                </th>
                <th></th>
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

@push('bottom_scripts')
    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('js/clear-form-fields.js') }}"></script>
    <script src="{{ asset('js/submit-only-filled.js') }}"></script>
@endpush
