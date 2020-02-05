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
           class="form-control question-text" placeholder="Запитання"
           value="{{ old("q.{$type}.{$question->id}.name", $question->question ?? '') }}" required="required">

    <div class="variants-wrapper">
        @foreach($question->answerOptions as $option)
            @include('blocks.admin.answer-option-line', [
              'optionIndex' => $loop->iteration,
            ])
        @endforeach
    </div>

    <button type="button" class="btn btn-outline-primary btn-sm button-add-variant mt-2"><i
            class="fas fa-plus"></i></button>
</li>
