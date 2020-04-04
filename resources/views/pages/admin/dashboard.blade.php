@extends('layouts.dashboard', ['baseLayout' => 'layouts.root.admin'])

@section('dashboard-content')
    <div class="row">
        <div class="col-3">
            <a href="{{ route('admin.change-password')}}"
               class="finish-test-btn mt-5 mb-5">Змінити пароль</a>
        </div>
    </div>
@endsection
