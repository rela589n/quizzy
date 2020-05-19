@extends('layouts.categories-single', ['baseLayout' => 'layouts.root.admin'])

@section('title')
    Результати {{ $subject->name }} - вибір теста
@endsection

@section('content')
    {{ Breadcrumbs::render('admin.results.subject', $subject) }}
    @parent
@endsection

@section('category-header-text') Оберіть тест з предмету {{ $subject->name }}: @endsection

@section('category-links')
    @forelse($subjectTests as $test)
        @include('blocks.entity-line', [
            'header' => $test->name,
            'link' => route('admin.results.subject.test', ['subject' => $subject->uri_alias, 'test' => $test->uri_alias]),
            'badge' => $test->results_count,
        ])
    @empty
        @component('layouts.blocks.empty-list-message')
            Немає жодного теста, що містив би результати
        @endcomponent
    @endforelse
@endsection

@include('blocks.scripts.no-scripts')
