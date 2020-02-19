<label for="ans[{{ $questionId }}][{{ $option->id }}][is_chosen]" class="d-block">
    <input type="hidden" name="ans[{{ $questionId }}][{{ $option->id }}][answer_option_id]" value="{{ $option->id }}">

    {{--  hack to always send value "1" or "0" --}}
    <input type="hidden" name="ans[{{ $questionId }}][{{ $option->id }}][is_chosen]" value="0">
    <input type="checkbox"
           id=ans[{{ $questionId }}][{{ $option->id }}][is_chosen]
           name=ans[{{ $questionId }}][{{ $option->id }}][is_chosen]
           value="1">

    {{ $option->text }}
</label>
