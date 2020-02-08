<li class="list-group-item mb-4 question"
    data-question="{{ $questionIndex }}"
    @if(!$new) data-question-id="{{ $question->id }}" @endif
    data-new="{{ $new ? 'true' : 'false' }}"
    data-modified="{{ $modified ? 'true' : 'false' }}">

    <label for="q[{{ $type }}][{{ $question->id }}][name]"
           class="text-center mb-3 h4 d-block question-header">
        Питання № {{ $questionIndex }}
    </label>

    <button type="button" class="btn btn-danger position-absolute button-delete-question" tabindex="-1">
        <i class="fas fa-trash"></i>
    </button>

    <input type="text"
           id="q[{{ $type }}][{{ $question->id }}][name]"
           name="q[{{ $type }}][{{ $question->id }}][name]"
           class="form-control question-text @error("q.$type.{$question->id}.name") is-invalid @enderror"
           placeholder="Запитання"
           value="{{ $question->question }}" required="required">

    @error("q.$type.{$question->id}.name")
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror

    <div class="variants-wrapper @error("q.$type.{$question->id}.v") is-invalid @enderror">
        @foreach($question->answerOptions as $option)
            @include('blocks.admin.answer-option-line', [
              'optionIndex' => $loop->iteration,
            ])
        @endforeach
    </div>
    @error("q.$type.{$question->id}.v")
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror


    <button type="button" class="btn btn-outline-primary btn-sm button-add-variant mt-2"><i
            class="fas fa-plus"></i></button>
</li>
