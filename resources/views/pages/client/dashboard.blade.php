@extends('layouts.dashboard', ['baseLayout' => 'layouts.root.client'])

@section('dashboard-content')
    <div class="row">
        <div class="col-3">
            <a href="{{ route('client.change-password')}}"
               class="finish-test-btn mt-5 mb-5">Змінити пароль</a>
        </div>
    </div>
    <div class="row">
        <div class="col-3">
            <a href="{{ route('client.documentation')}}"
               class="finish-test-btn mt-5 mb-5">Інструкція з використання</a>
        </div>
    </div>
@endsection
