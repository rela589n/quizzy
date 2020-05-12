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

    @include('blocks.admin.uri-alias-field', ['aliasable' => $group ?? null])

    <label for="year" class="form-info mb-4 h3">
        Виберіть рік вступу:
    </label>

    @php
        $currentYear = date('Y');
        $groupEnter = old('year', $group['year'] ?? $currentYear);
    @endphp
    <select class="browser-default custom-select mb-2 @error('year') is-invalid @enderror" required="required"
            id="year" name="year">
        @for ($i = min($groupEnter, $currentYear - 4); $i <= $currentYear; ++$i)
            <option value="{{ $i }}" @if($i === $groupEnter) selected="selected" @endif>{{ $i }}</option>
        @endfor
    </select>

    @error('year')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror

    @if(count($classMonitors) && $authUser->can('edit-class-monitors'))
        <label for="created_by" class="form-info mb-4 h3">
            Адміністратор групи (староста):
        </label>
        <select class="browser-default custom-select mb-2 @error('created_by') is-invalid @enderror"
                id="created_by" name="created_by">
            <option value="">Не обрано</option>

            @foreach($classMonitors as $classMonitor)
                <option value="{{ $classMonitor->id }}"
                        @if($classMonitor->id === $group->created_by) selected="selected" @endif>
                    {{ $classMonitor->full_name }}
                </option>
            @endforeach
        </select>

        @error('created_by')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    @endif

    @section('user-form-submit')
        @component('blocks.admin.submit-button', ['columns' => $submitSize ?? 12])
            {{ $submitButtonText ?? 'Створити' }}
        @endcomponent
    @show
</form>
