@extends('layouts.tests-single', ['baseLayout' => 'layouts.root.client', 'contentColumns' => 8])

@section('title')
    {{ $subject->name }} - {{ $test->name }}
@endsection

@section('category-header-text') Тест по предмету {{ $subject->name }} - {{ $test->name }} @endsection

@section('additions')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection

@section('main-container-class')
    @parent
    test-questions
@endsection

@section('save-button')
    <button type="submit" class="btn btn-primary btn-block finish-test-btn mt-5 mb-5">Завершити тест</button>
@endsection

@section('test-questions')
    @forelse($allQuestions as $question)
        @include('blocks.client.question-single', [
            'questionIndex' => $loop->iteration,
        ])
    @empty
        @component('layouts.blocks.empty-list-message')
            Немає доступних для проходження питань.
        @endcomponent
    @endforelse
@endsection

@section('content')
    @parent
    <div id="test-countdown">10:00</div>
@endsection

@push('bottom_scripts')
    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('js/alert-forbidden-switching-tabs.js') }}"></script>
    <script src="{{ asset('js/stopwatch.js') }}"></script>
    <script type="text/javascript">
        window.passTestCountDownMinutes = +"{!! json_encode($test->time) !!}";
    </script>
    <script src="{{ asset('js/test-countdown.js') }}"></script>
    <script src="{{ asset('js/close-when-switched-tab.js') }}"></script>
@endpush
