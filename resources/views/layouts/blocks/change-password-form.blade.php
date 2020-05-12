<form action="@yield('change-password-action')" method="post" class="auth">
    @csrf
    @section('change-password-header')
        <h2>Встановіть новий пароль:</h2>
    @show

    @section('old-password-label')
        <label for="password" class="form-info">
            Старий пароль:
        </label>
    @show
    @section('old-password-input')
        <div class="input-group" data-password-showable
             data-password-link-selector=".show-hide-password-link"
             data-password-icon-selector="i">

            @include('blocks.common.show-hide-password-input', ['passwordInputName' => 'password', 'passwordPlaceholder' => ''])
        </div>
    @show

    @section('new-password-label')
        <label for="new_password" class="form-info">
            Новий пароль:
        </label>
    @show

    @section('new-password-input')

        <div class="input-group" data-password-showable
             data-password-link-selector=".show-hide-password-link"
             data-password-icon-selector="i">

            @include('blocks.common.show-hide-password-input', ['passwordInputName' => 'new_password', 'passwordPlaceholder' => ''])
        </div>
    @show

    @section('new-password-confirm-label')
        <label for="new_password_confirmation" class="form-info">
            Підтвердіть пароль:
        </label>
    @show

    @section('new-password-confirm')
        <div class="input-group" data-password-showable
             data-password-link-selector=".show-hide-password-link"
             data-password-icon-selector="i">

            @include('blocks.common.show-hide-password-input', ['passwordInputName' => 'new_password_confirmation', 'passwordPlaceholder' => ''])
        </div>
    @show

    @section('change-password-submit')
        <button type="submit" class="btn btn-primary btn-block mt-3">Продовжити</button>
    @show
</form>

@section('bottom-scripts')
    @parent
    <script defer src="{{ asset('js/auth.js') }}"></script>
@endsection
