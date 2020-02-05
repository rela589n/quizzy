@extends('layouts.tests-single', ['baseLayout' => 'layouts.root.admin'])

@section('settings-link')
    <a class="btn btn-outline-dark finish-test-btn mt-1 float-right"
       href="{{ route('admin.tests.subject.test.settings', [
            $subject->uri_alias,
            $test->uri_alias
       ])}}">Перейти до налаштувань теста</a>
@endsection

@section('subject-name') {{ $subject->name }} @endsection
@section('test-name') {{ $test->name }} @endsection

@section('test-questions')
    @forelse($filteredQuestions as $question)

        {{-- Use distinct modified and new flags because        --}}
        {{-- simply selected question from database is not      --}}
        {{-- modified by user yet, but names for inputs must    --}}
        {{-- contain "[$type]" == "[modified]" substring        --}}
        @include('blocks.admin.question-single', [
            'questionIndex' => $loop->iteration,
            'type' => $question->type,
            'modified' => boolval(old("q.modified.{$question->id}", false)),
            'new' => boolval(old("q.new.{$question->id}", false))
        ])
    @empty
        <h3 class="list-group-item empty-questions-list-label">В цього теста питань поки що немає. Ви можете створити їх
            натиснувши кнопку нижче:</h3>
    @endforelse

    @foreach(old("q.deleted", []) as $deleted)
        <input type="hidden" name="q[deleted][]" value="{{ $deleted }}">
    @endforeach
@endsection

@section('save-button')
    <button type="submit" class="btn btn-primary btn-block finish-test-btn mt-5 mb-5">Зберегти</button>
@endsection
