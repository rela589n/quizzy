<form action="" method="post" class="auth text-dark">
    @csrf
    <label for="name" class="form-info mb-3 h3">
        Введіть назву теста:
    </label>
    <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Назва"
           required="required" value="{{  old('name',  $test->name ?? '') }}">
    @error('name')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror

    @include('blocks.admin.uri-alias-field', ['aliasable' => $test ?? null])

    <label for="time" class="form-info mb-3 h3">
        Введіть час (у хвилинах) для проходження теста:
    </label>
    <input id="time" name="time"
           type="number" class="form-control @error('time') is-invalid @enderror"
           placeholder="25"
           value="{{ old('time', $test->time ?? '') }}"
           required="required" min="1" max="65001">
    @error('time')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror

    <label for="mark_evaluator_type" class="form-info mb-4 h3">
        Методика виставлення оцінок
    </label>

    <select class="browser-default custom-select mb-2 @error('mark_evaluator_type') is-invalid @enderror"
            id="mark_evaluator_type" name="mark_evaluator_type">
        <option value="default" @if(($test->mark_evaluator_type ?? null) === 'default') selected="selected" @endif>За
            замовчуванням
        </option>
        <option value="custom" @if(($test->mark_evaluator_type ?? null) === 'custom') selected="selected" @endif>Власна
        </option>
    </select>

    @error('mark_evaluator_type')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror

    <div class="assessment-table-wrapper" style="display: none;">
        <div class="form-info ml-2 my-3 h4">
            Таблиця оцінювання
        </div>
        <table class="table order-list assignmentTable">
            <thead>
            <tr>
                <td>Оцінка</td>
                <td>Відсоток від</td>
                <td></td>
            </tr>
            </thead>
            <tbody>
            @foreach($marksPercentsMap ?? [] as $entry)
                <tr data-counter="{{$entry->id}}">
                    <td class="col-1">
                        <input type="number" min="1" max="100"
                               name="correlation_table[{{$entry->id}}][mark]"
                               value="{{ $entry->mark }}"
                               class="form-control form-control-sm map-mark-input"/>
                    </td>
                    <td class="col-1">
                        <input type="number" min="0" max="100" step=".01"
                               name="correlation_table[{{$entry->id}}][percent]"
                               value="{{ $entry->percent }}"
                               class="form-control form-control-sm map-percent-input"/>
                    </td>
                    <td class="col-1">
                        <button type="button" class="btn btn-sm btn-danger mt-1 position-absolute delete-row-button"
                                tabindex="-1">
                            <i class="fas fa-backspace"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td colspan="5">
                    <button type="button" class="btn m-auto btn-sm btn-secondary add-row-button">Додати рядок
                    </button>
                </td>
            </tr>
            <tr>
            </tr>
            </tfoot>
        </table>
        <hr class="mt-n1">
    </div>

    @if(isset($subjectsToIncludeFrom) && count($subjectsToIncludeFrom) > 0)
        <label for="include" class="form-info mb-2 h3">
            Включити питання з наступних тестів:
        </label>
        <div id="include-tests-accordion">
            @foreach($subjectsToIncludeFrom as $includeSubject)
                <div class="card mt-2">
                    <div class="card-header" id="heading-{{ $includeSubject->id }}">
                        <h5 class="mb-0 d-flex justify-content-between">
                            <button class="btn btn-link flex-grow-1 text-left" data-toggle="collapse" type="button"
                                    data-target="#collapse-{{ $includeSubject->id }}"
                                    aria-expanded="{{ $includeSubject->isExpanded ? 'true' : 'false' }}"
                                    aria-controls="collapse-{{ $includeSubject->id }}">
                                {{ $includeSubject->name }}
                            </button>

                            <button class="btn btn-sm btn-outline-dark include-full-subject-button" data-toggle="collapse"
                                    type="button">
                                включити повністю
                            </button>
                        </h5>
                    </div>

                    <div id="collapse-{{ $includeSubject->id }}"
                         class="collapse multi-collapse @if($includeSubject->isExpanded) show @endif"
                         aria-labelledby="heading-{{ $includeSubject->id }}">

                        <div class="card-body">
                            @foreach($includeSubject->tests as $includeTest)
                                <div class="form-row align-items-center flex-nowrap justify-content-start">
                                    <div class="col-auto">
                                        <div class="form-check ">
                                            <div class="d-inline-block"></div>
                                            <input id="include[{{ $includeTest->id }}][necessary]"
                                                   name="include[{{ $includeTest->id }}][necessary]"
                                                   type="checkbox"
                                                   class="form-check-input mt-2 is-correct required-target"
                                                   data-required="include[{{ $includeTest->id }}][count]"
                                                   @if($includeTest->isNecessary) checked="checked" @endif>
                                        </div>
                                    </div>

                                    @php($isCurrentTest = ($includeTest->id === ($test->id ?? -1)))

                                    <div class="col-form-label">
                                        <label for="include[{{ $includeTest->id }}][necessary]"
                                               class="form-check-label variant-text">

                                            @if($isCurrentTest)
                                                <strong>{{ $includeTest->name }} (Поточний тест)</strong>
                                            @else
                                                {{ $includeTest->name }}
                                            @endif
                                        </label>
                                    </div>

                                    <div class="@error("include.{$includeTest->id}.count") col-auto @else col-2  @enderror">
                                        <input id="include[{{ $includeTest->id }}][count]"
                                               name="include[{{ $includeTest->id }}][count]"
                                               type="number"
                                               class="form-control form-control-sm @error("include.{$includeTest->id}.count") is-invalid @enderror"
                                               placeholder="{{ $includeTest->questions_count }}"
                                               min="1" max="999"
                                               value="{{ $includeTest->includeCount }}"
                                               @if($includeTest->isNecessary) required="required" @endif {{-- if checkbox checked then it is required--}}
                                        >
                                        @error("include.{$includeTest->id}.count")
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @component('blocks.admin.submit-button', ['columns' => $submitSize ?? 12])
        {{ $submitButtonText ?? 'Зберегти' }}
    @endcomponent
</form>

@section('bottom-scripts')
    @parent
    <script defer src="{{ asset('js/required-if.js') }}"></script>
    @include('blocks.scripts.bootstrap')
    <script defer src="{{ asset('js/pages/test-form.js') }}"></script>
@endsection
