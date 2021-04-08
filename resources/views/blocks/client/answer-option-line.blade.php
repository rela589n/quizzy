<label for="ans[{{ $questionId }}][{{ $option->id }}][is_chosen]" class="d-block no-select">
    <input type="hidden" name="ans[{{ $questionId }}][{{ $option->id }}][answer_option_id]" value="{{ $option->id }}">

    <input type="checkbox"
           id=ans[{{ $questionId }}][{{ $option->id }}][is_chosen]
           name=ans[{{ $questionId }}][{{ $option->id }}][is_chosen]
           value="1" {{-- to send '1' instead of 'on'--}}
           {{ $checkboxAdditions ?? '' }}
    >

    {{ $option->text }}
</label>
