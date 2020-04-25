@extends('blocks.common.question-single-view')

@section('answer-options')
    @foreach($question->answerOptions as $option)
        {{-- To conveniently create results --}}
        <input type="hidden" name="asked[{{ $question->id }}][question_id]" value="{{ $question->id }}">

        @include('blocks.client.answer-option-line', [
          'optionIndex' => $loop->iteration,
          'questionId' => $question->id,
        ])
    @endforeach
@overwrite
