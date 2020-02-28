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
        <input id="password" name="password" type="password"
               class="form-control @error('password') is-invalid @enderror" aria-label="Username" required="required" value="{{ old('password') }}">
        @error('password')
        <span class="invalid-feedback" role="alert"><label for="password">{{ $message }}</label></span>
        @enderror
    @show

    @section('new-password-label')
        <label for="new_password" class="form-info">
            Новий пароль:
        </label>
    @show

    @section('new-password-input')
        <input id="new_password" name="new_password" type="password"
               class="form-control @error('new_password') is-invalid @enderror"
               aria-label="Password" required="required" value="{{ old('new_password') }}">
        @error('new_password')
        <span class="invalid-feedback" role="alert"><label for="new_password">{{ $message }}</label></span>
        @enderror
    @show

    @section('new-password-confirm-label')
        <label for="new_password_confirmation" class="form-info">
            Підтвердіть пароль:
        </label>
    @show

    @section('new-password-confirm')
        <input id="new_password_confirmation" name="new_password_confirmation" type="password"
               class="form-control @error('new_password_confirmation') is-invalid @enderror"
               aria-label="Password" required="required" value="{{ old('new_password_confirmation') }}">
        @error('new_password_confirmation')
        <span class="invalid-feedback" role="alert"><label for="new_password_confirmation">{{ $message }}</label></span>
        @enderror
    @show

    @section('change-password-submit')
        <button type="submit" class="btn btn-primary btn-block mt-3">Продовжити</button>
    @show
</form>
