@extends('layouts.categories-single', ['baseLayout' => 'layouts.root.admin'])

@section('title')
    {{ $subject->name  }} - тести
@endsection

@section('content')
    {{ Breadcrumbs::render('admin.tests.subject', $subject) }}
    @parent
@endsection

@section('category-settings-link')
    @if($authUser->can('update-subjects'))
        @include('blocks.admin.settings-link', [
            'link' => route('admin.tests.subject.settings', ['subject' => $subject->uri_alias]),
            'text' => 'Перейти до налаштувань предмета'
        ])
    @endif
@endsection

@section('category-header-text') Існуючі тести з предмету {{ $subject->name }} @endsection

@section('category-links')
    @forelse($subject->tests as $test)
        @include('blocks.entity-line', [
            'header' => $test->name,
            'link' => route('admin.tests.subject.test', ['subject' => $subject->uri_alias, 'test' => $test->uri_alias]),
            'badge' => $test->questions_count,
        ])
    @empty
        @component('layouts.blocks.empty-list-message')
            Тестів поки що немає. Можете створити новий натиснувши кнопку нижче:
        @endcomponent
    @endforelse
@endsection

@section('category-new-btn')
    @if($authUser->can('create-tests'))
        @include('blocks.admin.create-new-link', [
            'link' => route('admin.tests.subject.new', ['subject' => $subject->uri_alias]),
            'text' => 'Новий'
        ])
    @endif
@endsection
