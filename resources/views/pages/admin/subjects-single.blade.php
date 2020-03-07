@extends('layouts.categories-single', ['baseLayout' => 'layouts.root.admin'])

@section('category-settings-link')
    <a class="btn btn-outline-dark finish-test-btn mt-1 float-right"
       href="{{ route('admin.tests.subject.settings', ['subject' => $subject->uri_alias]) }}">
        Перейти до налаштувань предмета
    </a>
@endsection

@section('category-header-text') Існуючі тести з предмету {{ $subject->name }} @endsection

@section('category-links')
    @forelse($subject->tests as $test)
        @include('blocks.admin.test-line')
    @empty
        @component('layouts.blocks.empty-list-message')
            Тестів поки що немає. Можете створити новий натиснувши кнопку нижче:
        @endcomponent
    @endforelse
@endsection

@section('category-new-btn')
    <a class="btn btn-primary finish-test-btn mt-4 btn-block"
       href="{{ route('admin.tests.subject.new', ['subject' => $subject->uri_alias]) }}">Новий</a>
@endsection
