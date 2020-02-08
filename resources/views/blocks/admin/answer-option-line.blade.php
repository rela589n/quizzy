<div class="form-row align-items-center" data-variant="{{ $optionIndex }}">
    <div class="col-auto">
        <label class="form-check d-inline pb-1 mb-0">
            <input class="form-check-input is-correct"
                   type="checkbox"
                   name="q[{{ $type }}][{{ $question->id }}][v][{{ $option->id }}][is_right]"
                   @if( $option->is_right ?? false) checked="checked" @endif
            >
        </label>
    </div>
    <div class="col-form-label col-xl-11 col-lg-10 col-sm-9 col-8">
        <label class="form-check-label d-block">
            <input type="text" class="form-control form-control-sm variant-text @error("q.{$type}.{$question->id}.v.{$option->id}.text") is-invalid @enderror"
                   name="q[{{ $type }}][{{ $question->id }}][v][{{ $option->id }}][text]"
                   placeholder="Варіант № {{ $optionIndex }}"
                   value="{{ $option->text }}"
                   required="required">

            @error("q.{$type}.{$question->id}.v.{$option->id}.text")
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </label>
    </div>

    <div class="col-auto">
        <button type="button" class="btn btn-outline-danger btn-sm button-delete-variant"
                tabindex="-1"><i class="fas fa-trash"></i></button>
    </div>
</div>
