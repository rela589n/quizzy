@extends('layouts.categories-single', ['baseLayout' => 'layouts.root.client'])

@section('title')
    {{ $subject->name }} - вибір теста
@endsection

@section('category-header-text') {{ $subject->name }} - оберіть тест:  @endsection

@section('category-links')
    @forelse($availableTests as $test)
        @include('blocks.entity-line', [
            'header' => $test->name,
            'remainingAttemptsMessage' => $test->remainingAttemptsMessage,
            'link' => route('client.tests.subject.test', ['subject' => $subject->uri_alias, 'test' => $test->uri_alias]),
            'badge' => $test->questions_max_count === $test->questions_count
                    ? $test->questions_count
                    : "$test->questions_count / $test->questions_max_count",
        ])
    @empty
        @component('layouts.blocks.empty-list-message')
            Немає доступних тестів по вибраному предмету
        @endcomponent
    @endforelse
@endsection

@include('blocks.scripts.no-scripts')
