@extends('layouts.tests-single',
    [
        'baseLayout' => 'layouts.root.client',
        'contentColumns' => 8,
        'passTestAction' => action([\App\Http\Controllers\Client\Tests\TestsController::class, 'storeQuestionResponse'], ['subject' => $subject->uri_alias, 'test' => $test->uri_alias]),
        'finishTestAction' => action([\App\Http\Controllers\Client\Tests\TestsController::class, 'finishTest'], ['subject' => $subject->uri_alias, 'test' => $test->uri_alias]),
    ]
)

@php
    /** @var \App\Models\Test $test */
@endphp

@section('title')
    {{ $subject->name }} - {{ $test->name }}
@endsection

@section('category-header-text') Тест по предмету {{ $subject->name }} - {{ $test->name }} @endsection

@section('main-container-class')
    @parent
    test-questions
@endsection

@section('save-button')
    {{--    @if(count($allQuestions))--}}
    <button type="submit" class="btn btn-primary btn-block finish-test-btn mt-5 mb-5">Далі</button>
    {{--    @else--}}
    {{--    <a href="{{ route('client.tests.subject', ['subject' => $subject->uri_alias]) }}"--}}
    {{--       class="btn btn-primary btn-block finish-test-btn mt-5 mb-5">Завершити тест</a>--}}
    {{--    @endif--}}
@endsection

@section('test-questions')
    @include('blocks.client.question-single', [
        'questionIndex' => $questionIndex,
        'restrictTextSelect' => $test->restrict_text_selection,
    ])
@endsection

@section('additions')
    @if ($errors->any())
        <div class="alert alert-danger mt-5">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection

@section('content')
    @parent
    <div id="test-countdown">10:00</div>
@endsection

@section('bottom-scripts')
    @parent

    @if($test->restrict_extraneous_activity)
        @if(0 === $questionIndex)
            <script defer src="{{ asset('js/alert-forbidden-switching-tabs.js') }}"></script>
        @endif
    @endif

    <script defer src="{{ asset('js/stopwatch.js') }}"></script>
    <script type="text/javascript">
        window.passTestCountDownSeconds = +{{ $remainingTime }};
        window.currentSubject = JSON.parse('{!! json_encode($subject->only(['id', 'uri_alias'])) !!}');
        window.currentTest = JSON.parse('{!! json_encode($test->only(['id', 'uri_alias'])) !!}');
    </script>
    <script defer src="{{ asset('js/test-countdown.js') }}"></script>

    @if($test->restrict_extraneous_activity)
        <script defer src="{{ asset('js/close-when-switched-tab.js') }}"></script>
    @endif
@endsection
