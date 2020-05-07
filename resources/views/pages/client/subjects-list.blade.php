@extends('layouts.categories-single', ['baseLayout' => 'layouts.root.client' ])

@section('title')
    Вибір предмета тестування
@endsection

@section('category-header-text')
    Оберіть предмет тестування:
@endsection

@section('category-links')
    @forelse($subjects as $subject)
        @include('blocks.entity-line', [
            'header' => $subject->name,
            'link' => route('client.tests.subject', ['subject' => $subject->uri_alias]),
            'badge' => $subject->tests_count
        ])
    @empty
        @component('layouts.blocks.empty-list-message')
            Немає жодного доступного предмета тестування
        @endcomponent
    @endforelse
@endsection

@include('blocks.scripts.no-scripts')
