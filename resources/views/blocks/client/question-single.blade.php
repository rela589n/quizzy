<li class="list-group-item mb-4 question">
    <h4 class="text-center">Питання № {{ $questionIndex }}</h4>

    <h5>{{ $question->question }}</h5>

    @foreach($question->answerOptions as $option)
{{--        To conveniently create results--}}
        <input type="hidden" name="asked[{{ $question->id }}][question_id]" value="{{ $question->id }}">

        @include('blocks.client.answer-option-line', [
          'optionIndex' => $loop->iteration,
          'questionId' => $question->id
        ])
    @endforeach
</li>
