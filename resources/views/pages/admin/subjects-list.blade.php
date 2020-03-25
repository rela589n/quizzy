@extends('layouts.categories-single', ['baseLayout' => 'layouts.root.admin' ])

@section('title')
    Список предметів тестування
@endsection

@section('content')
    {{ Breadcrumbs::render('admin.tests') }}
    @parent
@endsection

@section('category-header-text')
    Усі доступні предмети тестування:
@endsection

@section('category-links')
    @forelse($subjects as $subject)
        @include('blocks.entity-line', [
            'header' => $subject->name,
            'link' => route('admin.tests.subject', ['subject' => $subject->uri_alias ]),
            'badge' => $subject->tests_count
        ])
    @empty
        @component('layouts.blocks.empty-list-message')
            Немає жодного доступного предмета
        @endcomponent
    @endforelse
@endsection

@section('category-new-btn')
    @if($authUser->can('create-subjects'))
        @include('blocks.admin.create-new-link', [
            'link' => route('admin.tests.new')
        ])
    @endif
@endsection
