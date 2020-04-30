@extends('layouts.tests-single', ['baseLayout' => 'layouts.root.admin'])

@section('title')
    {{ $subject->name }} - {{ $test->name }}
@endsection

@section('content')
    {{ Breadcrumbs::render('admin.tests.subject.test', $test, $subject) }}
    @parent
@endsection

@section('category-header-text') {{ $subject->name }} - {{ $test->name }}, список запитань: @endsection

@section('test-questions')
    @forelse($test->nativeQuestions as $question)
        @include('blocks.admin.question-single-read-only', [
            'questionIndex' => $loop->iteration,
            'question' => $question
        ])
    @empty
        @component('layouts.blocks.empty-list-message')
            Цей тест не містить жодного власного питання
        @endcomponent
    @endforelse
@endsection

@section('save-button')
    <a href="{{ route('admin.tests.subject', ['subject' => $subject->uri_alias]) }}" class="mt-2 mb-3 d-inline-block"><i
            class="fas fa-backward"></i> Назад</a>
@endsection

@push('bottom_scripts')
    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('js/read-only-input.js') }}"></script>
@endpush
