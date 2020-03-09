@extends('layouts.categories-single', ['baseLayout' => 'layouts.root.admin', 'contentColumns' => 12])

@section('category-header-text') {{ $subject->name }} - {{ $test->name }} результати: @endsection

@section('category-main-content')
    <form action="" method="get" class="form-clearable">
        <table class="table table-bordered table-striped">
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
                    <th scope="row">{{ $testResult->id }}</th>
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
            <tr>
                <th class="input ui-state-default" rowspan="1" colspan="1">
                    <input name="resultId" value="{{ request('resultId') }}" type="number"
                           class="form-control form-control-sm table-input-narrow" min="1" placeholder="id">
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
                    <input name="result" type="number" value="{{ request('result') }}" min="0" max="100" step="0.01"
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
                    <div class="d-flex justify-content-between">
                        <button type="reset" class="btn btn-primary">Скинути фільтри</button>
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
@endpush
