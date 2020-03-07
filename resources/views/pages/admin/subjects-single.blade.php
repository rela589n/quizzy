@extends('layouts.categories-single', ['baseLayout' => 'layouts.root.admin'])

@section('category-settings-link')
    @include('blocks.admin.settings-link', [
        'link' => route('admin.tests.subject.settings', ['subject' => $subject->uri_alias]),
        'text' => 'Перейти до налаштувань предмета'
    ])
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
    @include('blocks.admin.create-new-link', [
        'link' => route('admin.tests.subject.new', ['subject' => $subject->uri_alias]),
        'text' => 'Новий'
    ])
@endsection
