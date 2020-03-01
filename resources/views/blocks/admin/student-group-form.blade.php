<form method="post" class="auth text-dark">
    @csrf
    <label for="name" class="form-info mb-4 h3">
        Введіть назву групи:
    </label>
    <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Назва"
           required="required" value="{{  old('name',  $group['name'] ?? '') }}">

    @error('name')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror

    <label for="alias" class="form-info mb-4 h3">
        Введіть псевдонім для використання в uri:
    </label>

    <div class="form-group form-row align-items-start">
        <div class="col-9">
            <input id="alias" name="uri_alias" type="text" class="form-control @error('uri_alias') is-invalid @enderror"
                   placeholder="Псевдонім"
                   required="required" value="{{ old('uri_alias', $group['uri_alias'] ?? '') }}">

            @error('uri_alias')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="col-3">
            <button tabindex="-1" type="button" id="auto-generate-translit" class="btn btn-primary btn-block"
                    disabled="disabled">Автоматично
            </button>
        </div>
    </div>

    <label for="year" class="form-info mb-4 h3">
        Виберіть рік вступу:
    </label>

    @php
        $currentYear = date('Y');
        $groupEnter = old('year', $group['year'] ?? $currentYear);
    @endphp
    <select class="browser-default custom-select @error('year') is-invalid @enderror" required="required" id="year"
            name="year">
        @for ($i = min($groupEnter, $currentYear - 4); $i <= $currentYear; ++$i)
            <option value="{{ $i }}" @if($i === $groupEnter) selected="selected" @endif>{{ $i }}</option>
        @endfor
    </select>

    @error('year')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror

    <button type="submit"
            class="btn btn-primary btn-block finish-test-btn mt-4">{{ $submitButtonText ?? 'Створити' }}</button>
</form>
