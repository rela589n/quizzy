@extends('layouts.tests-single', ['baseLayout' => 'layouts.root.admin'])

@section('category-settings-link')
    <a class="btn btn-outline-dark finish-test-btn mt-1 float-right"
       href="{{ route('admin.tests.subject.test.settings', [
            $subject->uri_alias,
            $test->uri_alias
       ])}}">Перейти до налаштувань теста</a>
@endsection

@section('category-header-text') Тест по предмету {{ $subject->name }} - {{ $test->name }} @endsection

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
@endsection

@section('additions')
    <div class="button-wrap text-center">
        <button type="button" class="btn btn-primary btn-lg button-add-question"><i
                class="fas fa-plus"></i></button>
    </div>
    <input
        type="hidden"
        name="last-answer-option-id"
        id="last-answer-option-id"
        value="{{ $lastAnswerOptionId }}">

    @foreach(old('q.deleted', []) as $deleted)
        <input type="hidden" name="q[deleted][]" value="{{ $deleted }}">
    @endforeach

    @foreach(old('v.deleted', []) as $deleted)
        <input type="hidden" name="v[deleted][]" value="{{ $deleted }}">
    @endforeach
@endsection

@section('save-button')
    <button type="submit" class="btn btn-primary btn-block finish-test-btn mt-5 mb-5">Зберегти</button>
@endsection

@push('bottom_scripts')
    <script src="{{ asset('js/test_edit.js') }}"></script>
@endpush

@isset($message)
    @push('bottom_scripts')
        <script>
            window.backEndMessage = {!! json_encode($message) !!};
        </script>
        <script src="{{ asset('js/show-popup.js') }}"></script>
    @endpush
@endisset
