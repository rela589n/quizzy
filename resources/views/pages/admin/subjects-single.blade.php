@extends('layouts.subjects-single', ['baseLayout' => 'layouts.root.admin'])

@section('settings-link')
    <a class="btn btn-outline-dark finish-test-btn mt-1 float-right" href="{{ url()->current() }}/settings">Перейти до
        налаштувань предмета</a>
@endsection

@section('subject-name') oop @endsection

@section('test-links')
    {{-- todo traverse given array and print all entities  --}}
    @forelse($tests as $test)
        @include('blocks.admin.test-line')
    @empty
        <h3 class="list-group-item">Тестів поки що немає. Можете створити новий натиснувши кнопку нижче:</h3>
    @endforelse
@endsection

@section('create-new-link')
    <a class="btn btn-primary finish-test-btn mt-4 btn-block" href="{{ url()->current() }}/new">Новий</a>
@endsection
