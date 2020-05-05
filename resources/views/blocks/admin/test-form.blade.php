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

    @if(isset($subjectsToIncludeFrom) && count($subjectsToIncludeFrom) > 0)
        <label for="include" class="form-info mb-2 h3">
            Включити питання з наступних тестів:
        </label>
        <div id="include-tests-accordion">
            @foreach($subjectsToIncludeFrom as $includeSubject)
                <div class="card">

                    @php($subjectExpanded = isset($test) && $includeSubject->id === $test->test_subject_id)

                    <div class="card-header" id="heading-{{ $includeSubject->id }}">
                        <h5 class="mb-0">
                            <button class="btn btn-link" data-toggle="collapse" type="button"
                                    data-target="#collapse-{{ $includeSubject->id }}" aria-expanded="{{ $subjectExpanded ? 'true' : 'false' }}"
                                    aria-controls="collapse-{{ $includeSubject->id }}">
                                {{ $includeSubject->name }}
                            </button>
                        </h5>
                    </div>

                    <div id="collapse-{{ $includeSubject->id }}" class="collapse @if($subjectExpanded) show @endif"
                         aria-labelledby="heading-{{ $includeSubject->id }}" data-parent="#include-tests-accordion">
                        <div class="card-body">
                            @foreach($includeSubject->tests as $includeTest)
                                @php($pivot = (isset($test)) ? ($test->tests->find($includeTest->id)->pivot ?? null) : null)

                                <div class="form-row align-items-center flex-nowrap justify-content-start">
                                    <div class="col-auto">
                                        <div class="form-check ">
                                            <div class="d-inline-block"></div>
                                            <input id="include[{{ $includeTest->id }}][necessary]"
                                                   name="include[{{ $includeTest->id }}][necessary]"
                                                   type="checkbox"
                                                   class="form-check-input mt-2 is-correct required-target"
                                                   data-required="include[{{ $includeTest->id }}][count]"
                                                   @if(old("include.{$includeTest->id}.necessary", $pivot  ?? false)) checked="checked" @endif>
                                        </div>
                                    </div>
                                    <div class="col-form-label">
                                        <label for="include[{{ $includeTest->id }}][necessary]"
                                               class="form-check-label variant-text">
                                            {{ $includeTest->name }} {{ ($includeTest->id == ($test->id ?? '-7')) ? '(Поточний тест)' : '' }}
                                        </label>
                                    </div>

                                    <div class="@error("include.{$includeTest->id}.count") col-auto @else col-2  @enderror">
                                        <input id="include[{{ $includeTest->id }}][count]"
                                               name="include[{{ $includeTest->id }}][count]"
                                               type="number"
                                               class="form-control form-control-sm @error("include.{$includeTest->id}.count") is-invalid @enderror"
                                               placeholder="{{ $includeTest->questions_count }}"
                                               min="1" max="999"
                                               value="{{ old("include.{$includeTest->id}.count", $pivot->questions_quantity ??  '') }}"
                                               @if(old("include.{$includeTest->id}.necessary", $pivot ?? false)) required="required" @endif {{-- if checkbox checked then it is required--}}
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
