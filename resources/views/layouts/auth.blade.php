@extends('layouts.root.base')

@section('body-class')
    @parent
    auth
@endsection

@section('content')
    <div class="container h-100">
        <div class="row h-100">
            <div class="col-10 col-sm-8 col-md-6 col-lg-5 col-xl-4 m-auto mtb-auto">
                <form method="post" class="@section('form-class') auth @show ">
                    @csrf
                    @section('auth-form-header')
                        <h2>Аутентифікація</h2>
                    @show

                    @section('login-label')
                        <label for="name" class="form-info">
                            Логін (email):
                        </label>
                    @show

                    @section('login-input')
                        <input id="name" name="email" type="text"
                               class="form-control @error('email') is-invalid @enderror"
                               placeholder="Логін"
                               required="required"
                               value="{{ old('email') }}">

                        @error('email')
                        <span class="invalid-feedback" role="alert"><label for="email">{{ $message }}</label></span>
                        @enderror
                    @show

                    @section('password-label')
                        <label for="password" class="form-info @error('password') error @enderror">
                            Пароль:
                        </label>
                    @show

                    @section('password-input')
                        <input id="password" name="password" type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Пароль"
                               required="required"
                               value="{{ old('password') }}">

                        @error('password')
                        <span class="invalid-feedback" role="alert"><label for="password">{{ $message }}</label></span>
                        @enderror
                    @show

                    @section('remember-checkbox')
                        <input id="remember" name="remember" type="checkbox" @if(old('remember')) checked="checked" @endif>
                    @show

                    @section('remember-label')
                        <label for="remember" class="form-info">Запам'ятати</label>
                    @show

                    @section('submit-button')
                        <button type="submit" class="btn btn-primary btn-block">Вхід</button>
                    @show
                </form>

                {{--                @if ($errors->any())--}}
                {{--                    <ul>--}}
                {{--                        @foreach ($errors->all() as $error)--}}
                {{--                            <li>{{ $error }}</li>--}}
                {{--                        @endforeach--}}
                {{--                    </ul>--}}
                {{--                @endif--}}
            </div>
        </div>
    </div>
@endsection

@section('bottom-scripts')
    @parent
    <script defer src="{{ asset('js/auth.js') }}"></script>
@endsection
