<form action="@yield('user-form-action')" method="post" class="auth user-form text-dark">
    @csrf
    @yield('user-form-before')
    <div class="form-group form-row align-items-start">
        <label for="surname" class="form-info h3 m-0 col-5 col-sm-4 col-md-3">
            Прізвище:
        </label>
        <div class="col-7 col-sm-8 col-md-9">
            <input id="surname" name="surname" type="text"
                   class="form-control @error('surname') is-invalid @enderror"
                   placeholder="Прізвище" required="required" value="{{ old('surname', $user->surname ?? '') }}">

            @error('surname')
            <span class="invalid-feedback" role="alert"><label for="surname">{{ $message }}</label></span>
            @enderror
        </div>
    </div>

    <div class="form-group form-row align-items-start">
        <label for="name" class="form-info h3 m-0 col-2">
            Ім'я:
        </label>
        <div class="col-10">
            <input id="name" name="name" type="text"
                   class="form-control @error('name') is-invalid @enderror"
                   placeholder="Ім'я" required="required" value="{{ old('name', $user->name ?? '') }}">

            @error('name')
            <span class="invalid-feedback" role="alert"><label for="name">{{ $message }}</label></span>
            @enderror
        </div>
    </div>
    <div class="form-group form-row align-items-start">
        <label for="patronymic" class="form-info h3 m-0 col-5 col-sm-4 col-md-3">
            По-батькові:
        </label>
        <div class="col-7 col-sm-8 col-md-9">
            <input id="patronymic" name="patronymic" type="text"
                   class="form-control @error('patronymic') is-invalid @enderror" placeholder="По-батькові"
                   required="required" value="{{ old('patronymic', $user->patronymic ?? '') }}">

            @error('patronymic')
            <span class="invalid-feedback" role="alert"><label for="patronymic">{{ $message }}</label></span>
            @enderror
        </div>
    </div>

    <div class="form-group form-row align-items-start">
        <label for="email" class="form-info h3 m-0 col-5 col-md-4 col-lg-3">
            Логін (email):
        </label>
        <div class="col-7 col-md-8 col-lg-9">
            <input id="email" name="email" type="text"
                   class="form-control @error('email') is-invalid @enderror" placeholder="Логін"
                   required="required" value="{{ old('email', $user->email ?? '') }}">

            @error('email')
            <span class="invalid-feedback" role="alert"><label for="email">{{ $message }}</label></span>
            @enderror
        </div>
    </div>

    <div class="form-group form-row align-items-start">
        <label for="password" class="form-info h3 m-0 col-4 col-sm-3 col-md-2">
            Пароль:
        </label>

        <div class="input-group mb-1 col-8 col-sm-9 col-md-10" data-password-showable
             data-password-link-selector=".show-hide-password-link"
             data-password-icon-selector="i">

            @include('blocks.common.show-hide-password-input', [
                'passwordInputName' => 'password',
                'passwordPlaceholder' => $userPasswordPlaceholder ?? '1234',
                'passwordRequired' => !isset($user)
            ])
        </div>
    </div>

    @yield('user-form-additions')

    @section('user-form-submit')
        @component('blocks.admin.submit-button', ['columns' => $submitSize ?? 12])
            {{ $submitButtonText ?? 'Створити' }}
        @endcomponent
    @show
</form>

@section('bottom-scripts')
    @parent
    <script defer src="{{ asset('js/auth.js') }}"></script>
@endsection
