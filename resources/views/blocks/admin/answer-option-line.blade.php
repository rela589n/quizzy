<div class="form-row align-items-center" data-variant="{{ $loop->iteration }}">
    <div class="col-auto">
        <label class="form-check-label d-block">
            <input class="form-check-input is-correct"
                   type="checkbox"
                   name="q[modified][{{ $question->id }}][v][{{ $option->id }}][is_right]"
                   @if($option->is_right) checked="checked" @endif
            >
        </label>
    </div>
    <div class="col-form-label col-xl-11 col-lg-10 col-sm-9 col-8">
        <label class="form-check-label d-block">
            <input type="text" class="form-control form-control-sm variant-text"
                   name="q[modified][{{ $question->id }}][v][{{ $option->id }}][text]"
                   placeholder="Варіант № {{ $loop->iteration }}" value="{{ $option->text }}"
                   required="required">
        </label>
    </div>

    <div class="col-auto">
        <button type="button" class="btn btn-outline-danger btn-sm button-delete-variant"
                tabindex="-1"><i class="fas fa-trash"></i></button>
    </div>
</div>
