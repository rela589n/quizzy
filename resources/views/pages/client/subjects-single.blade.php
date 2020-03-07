@extends('layouts.categories-single', ['baseLayout' => 'layouts.root.client'])

@section('category-header-text') {{ $subject->name }} - оберіть тест:  @endsection

@section('category-links')
    @forelse($subject->tests as $test)
        @include('blocks.client.test-line')
    @empty
        @component('layouts.blocks.empty-list-message')
            Немає доступних тестів по вибраному предмету
        @endcomponent
    @endforelse
@endsection
