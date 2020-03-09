@extends('layouts.categories-single', ['baseLayout' => 'layouts.root.admin'])

@section('category-header-text') Оберіть тест з предмету {{ $subject->name }}: @endsection

@section('category-links')
    @forelse($subject->tests as $test)
        @include('blocks.entity-line', [
            'header' => $test->name,
            'link' => route('admin.results.subject.test', ['subject' => $subject->uri_alias, 'test' => $test->uri_alias]),
            'badge' => $test->results_count,
        ])
    @empty
        @component('layouts.blocks.empty-list-message')
            Немає жодного теста
        @endcomponent
    @endforelse
@endsection
