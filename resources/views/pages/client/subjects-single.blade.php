@extends('layouts.categories-single', ['baseLayout' => 'layouts.root.client'])

@section('category-header-text') {{ $subject->name }} - оберіть тест:  @endsection

@section('category-links')
    @forelse($subject->tests as $test)
        @include('blocks.entity-line', [
            'header' => $test->name,
            'link' => route('client.tests.subject.test', ['subject' => $test->subject->uri_alias, 'test' => $test->uri_alias]),
            'badge' => $test->questions_count
        ])
    @empty
        @component('layouts.blocks.empty-list-message')
            Немає доступних тестів по вибраному предмету
        @endcomponent
    @endforelse
@endsection
