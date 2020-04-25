@extends('blocks.common.question-single-view')

@section('answer-options')
    @foreach($question->answerOptions as $option)
        @include('blocks.client.answer-option-line', [
            'optionIndex' => $loop->iteration,
            'questionId' => $question->id,
            'checkboxAdditions' => sprintf(
              '%s %s',
              'data-read-only',
              $option->is_right ? 'checked="checked"' : ''
            )
        ])
    @endforeach
@overwrite
