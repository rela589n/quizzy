@extends('blocks.common.question-single-view')

@php
/** @var \App\Models\Question $question */
@endphp

@section('answer-options')
    @foreach($question->answerOptions as $option)
        {{-- To conveniently create results --}}
        <input type="hidden" name="asked[{{ $question->id }}][question_id]" value="{{ $question->id }}">
        <input type="hidden" name="asked[{{ $question->id }}][question_type]" value="{{ $question->type }}">

        @include('blocks.client.answer-option-line', [
          'optionIndex' => $loop->iteration,
          'questionId' => $question->id,
          'type' => $question->type,
        ])
    @endforeach
@overwrite
