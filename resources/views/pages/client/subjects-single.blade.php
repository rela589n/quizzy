@extends('layouts.subjects-single', ['baseLayout' => 'layouts.root.client'])

@section('header-text') {{ $subject->name }} - оберіть тест:  @endsection

@section('test-links')
    @forelse($subject->tests as $test)
        @include('blocks.client.test-line')
    @empty
        <h3 class="list-group-item">Немає доступних тестів по вибраному предмету</h3>
    @endforelse
@endsection

@section('settings-link') @endsection
@section('create-new-link') @endsection
