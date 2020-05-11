<form method="post" class="auth text-dark">
    @csrf
    <label for="name" class="form-info mb-4 h3">
        Введіть назву відділення:
    </label>
    <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Назва"
           required="required" value="{{  old('name',  $department['name'] ?? '') }}">

    @error('name')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror

    @include('blocks.admin.uri-alias-field', ['aliasable' => $department ?? null])

    @section('user-form-submit')
        @component('blocks.admin.submit-button', ['columns' => $submitSize ?? 12])
            {{ $submitButtonText ?? 'Створити' }}
        @endcomponent
    @show
</form>
