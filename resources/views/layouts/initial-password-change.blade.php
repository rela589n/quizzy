@extends('layouts.root.base')

@section('body-class')
    @parent
    auth
@endsection

@section('content')
    <div class="container h-100">
        <div class="row h-100">
            <div class="col-4"></div>
            <div class="col-4 mtb-auto">
                @yield('change-password-content')
            </div>
        </div>
    </div>
@endsection
