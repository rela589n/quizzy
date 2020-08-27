@extends('layouts.tests-single', ['baseLayout' => 'layouts.root.admin'])

@section('title')
    {{ $subject->name }} - {{ $test->name }}
@endsection

@section('content')
    {{ Breadcrumbs::render('admin.tests.subject.test', $test, $subject) }}
    @parent
@endsection

@section('category-settings-link')
    @if($authUser->can('update', $test))
        @include('blocks.admin.settings-link', [
            'link' => route('admin.tests.subject.test.settings', [ $subject->uri_alias, $test->uri_alias ]),
            'text' => 'Перейти до налаштувань теста'
        ])
    @endif
@endsection

@section('category-header-text') {{ $subject->name }} - {{ $test->name }}, список запитань: @endsection

@section('test-questions')
    @forelse($filteredQuestions as $question)

        {{-- Use distinct modified and new flags because        --}}
        {{-- simply selected question from database is not      --}}
        {{-- modified by user yet, but names for inputs must    --}}
        {{-- contain "[$type]" == "[modified]" substring        --}}
        @include('blocks.admin.question-single', [
            'questionIndex' => $loop->iteration,
            'type' => $question->type,
            'modified' => (bool)old("q.modified.{$question->id}", false),
            'new' => (bool)old("q.new.{$question->id}", false)
        ])
    @empty
        <h3 class="list-group-item empty-questions-list-label mb-4">Щоб створити питання, натисніть кнопку + нижче:</h3>
    @endforelse
@endsection

@section('additions')
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
    <div class="button-wrap text-center form-row mb-4">
        <div class="col-3">
            <button type="button" class="btn btn-primary btn-lg button-add-question" title="Додати питання"><i
                    class="fas fa-plus"></i></button>
        </div>
        <div class="col-6">
            <button type="submit" class="btn btn-primary btn-lg btn-block finish-test-btn">Зберегти</button>
        </div>
        <div class="col-1"></div>
        <div class="col-1">
            <a href="{{ route('admin.tests.subject.test.transfer', [
                            'subject' => $subject->uri_alias,
                            'test'    => $test->uri_alias
                        ]) }}"
               class="btn btn-primary btn-lg" title="Імпорт">
                <i class="fas fa-upload"></i>
            </a>
        </div>
        <div class="col-1">
            <a href="{{ route('admin.tests.subject.test.export', [
                            'subject' => $subject->uri_alias,
                            'test'    => $test->uri_alias
                        ]) }}"
               class="btn btn-primary btn-lg" title="Експорт">
                <i class="fas fa-download"></i>
            </a>
        </div>
    </div>
@endsection

@section('bottom-scripts')
    @parent
    <script defer src="{{ asset('js/test_edit.js') }}"></script>
@endsection
