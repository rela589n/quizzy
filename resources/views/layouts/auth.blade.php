@extends('layouts.root.base')

@section('title')
    Авторизація
@endsection

@section('body-class')
    @parent
    auth
@endsection

@section('content')
    <div class="container h-100">
        <div class="row h-100">
            <div class="col-4"></div>
            <div class="col-4 mtb-auto">
                <form action="" method="post" class="@section('form-class') auth @show ">
                    @section('auth-form-header')
                        <h2>Авторизація</h2>
                    @show

                    @section('login-label')
                        <label for="name" class="form-info">
                            Логін:
                        </label>
                    @show

                    @section('login-input')
                        <input id="name" type="text" class="form-control" placeholder="Логін" required="required">
                    @show

                    @section('password-label')
                        <label for="pass" class="form-info error">
                            Пароль:
                        </label>
                    @show

                    @section('password-input')
                        <input id="pass" type="password" class="form-control alert-danger" placeholder="Пароль"
                               required="required">
                    @show
                    <label for="pass" class="error">Довжина пароля повинна бути від 8 до 64 символів</label>

                    @section('remember-checkbox')
                        <input id="remember" type="checkbox" name="remember">
                    @show

                    @section('remember-label')
                        <label for="remember" class="form-info">Запам'ятати</label>
                    @show

                    @section('submit-button')
                        <button type="submit" class="btn btn-primary btn-block">Вхід</button>
                    @show
                </form>
            </div>
        </div>
    </div>
@endsection

@push('bottom_scripts')
    <script src="{{ asset('js/auth.js') }}"></script>
@endpush
