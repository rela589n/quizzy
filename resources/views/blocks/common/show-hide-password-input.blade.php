<input id="{{ $passwordInputName }}" name="{{ $passwordInputName }}" type="password"
       class="form-control @error($passwordInputName) is-invalid @enderror"
       placeholder="{{ $passwordPlaceholder ?? 'Пароль' }}"
       value="{{ old($passwordInputName) }}"
       @if($passwordRequired ?? true) required="required" @endif>

<div class="input-group-append">
    <a href="javascript: void(0);" tabindex="-1" class="input-group-text show-hide-password-link"><i class="fa fa-eye"
                                                                                       aria-hidden="true"></i></a>
</div>

@error($passwordInputName)
<span class="invalid-feedback" role="alert"><label
        for="{{ $passwordInputName }}">{{ $message }}</label></span>
@enderror
