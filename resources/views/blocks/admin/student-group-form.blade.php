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

    @include('blocks.admin.uri-alias-field')

    <label for="year" class="form-info mb-4 h3">
        Виберіть рік вступу:
    </label>

    @php
        $currentYear = date('Y');
        $groupEnter = old('year', $group['year'] ?? $currentYear);
    @endphp
    <select class="browser-default custom-select mb-2 @error('year') is-invalid @enderror" required="required" id="year"
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

    @section('user-form-submit')
        @component('blocks.admin.submit-button', ['columns' => $submitSize ?? 12])
            {{ $submitButtonText ?? 'Створити' }}
        @endcomponent
    @show
</form>
