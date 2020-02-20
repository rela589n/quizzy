@extends('layouts.tests-single', ['baseLayout' => 'layouts.root.client', 'contentColumns' => 8])
@section('subject-name') {{ $subject->name }} @endsection
@section('test-name') {{ $test->name }} @endsection

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

@section('categories-class')
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
        <h3 class="list-group-item">Немає доступних для проходження питань.</h3>
    @endforelse
@endsection

@section('content')
    @parent
    <div id="test-countdown">10:00</div>
@endsection

@push('bottom_scripts')
    <script src="{{ asset('js/stopwatch.js') }}"></script>
    <script type="text/javascript">
        window.passTestCountDownMinutes = +"{!! json_encode($test->time) !!}";
    </script>
    <script src="{{ asset('js/test-countdown.js') }}"></script>
@endpush
