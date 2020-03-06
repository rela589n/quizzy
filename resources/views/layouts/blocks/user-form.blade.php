<form action="@yield('user-form-action')" method="post" class="auth user-form text-dark">
    @csrf
    <div class="form-group form-row align-items-start">
        <label for="surname" class="form-info h3 m-0 col-3">
            Прізвище:
        </label>
        <div class="col-9">
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
        <label for="patronymic" class="form-info h3 m-0 col-3">
            По-батькові:
        </label>
        <div class="col-9">
            <input id="patronymic" name="patronymic" type="text"
                   class="form-control @error('patronymic') is-invalid @enderror" placeholder="По-батькові"
                   required="required" value="{{ old('patronymic', $user->patronymic ?? '') }}">

            @error('patronymic')
            <span class="invalid-feedback" role="alert"><label for="patronymic">{{ $message }}</label></span>
            @enderror
        </div>
    </div>

    <div class="form-group form-row align-items-start">
        <label for="email" class="form-info h3 m-0 col-3">
            Логін (email):
        </label>
        <div class="col-9">
            <input id="email" name="email" type="text"
                   class="form-control @error('email') is-invalid @enderror" placeholder="Логін"
                   required="required" value="{{ old('email', $user->email ?? '') }}">

            @error('email')
            <span class="invalid-feedback" role="alert"><label for="email">{{ $message }}</label></span>
            @enderror
        </div>
    </div>


    <div class="form-group form-row align-items-start">
        <label for="password" class="form-info h3 m-0 col-2">
            Пароль:
        </label>

        <div class="input-group mb-1 col-10" id="show_hide_password">
            <input id="password" name="password" type="password"
                   class="form-control @error('password') is-invalid @enderror"
                   placeholder="{{ $userPasswordPlaceholder ?? '1234'}}" value="{{ old('password') }}">

            <div class="input-group-append">
                <a href="javascript: void(0);" class="input-group-text"><i class="fa fa-eye" aria-hidden="true"></i></a>
            </div>
            @error('password')
            <span class="invalid-feedback" role="alert"><label for="password">{{ $message }}</label></span>
            @enderror
        </div>
    </div>

    @yield('user-form-additions')

    @section('user-form-submit')
        <button type="submit" class="btn btn-primary btn-block finish-test-btn mt-4">{{ $submitButtonText ?? 'Створити' }}</button>
    @show
</form>

@prepend('bottom_scripts')
    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('js/auth.js') }}"></script>
@endprepend
