<label class="d-block no-select">

    @if (\App\Models\Questions\QuestionType::CHECKBOXES()->equalsTo($type))
        <input type="hidden" name="ans[{{ $questionId }}][{{ $option->id }}][answer_option_id]" value="{{ $option->id }}">
        <input type="checkbox"
               name="ans[{{ $questionId }}][{{ $option->id }}][is_chosen]"
               value="1" {{-- to send '1' instead of 'on'--}}
            {{ $inputAdditions ?? '' }}
        >
    @elseif (\App\Models\Questions\QuestionType::RADIO()->equalsTo($type))
        <input type="radio"
                   name="ans_radio[{{ $questionId }}][answer_option_id]"
               value="{{ $option->id }}"
            {{ $inputAdditions ?? '' }}
        >
    @endif

    {{ $option->text }}
</label>
