@extends('layouts.categories-single', [
    'baseLayout' => 'layouts.root.client',
    'contentColumns' => 8
])

@php
    /** @var \App\Models\Test $test */
    /** @var \App\Models\TestSubject $subject */
@endphp

@section('title')
    Література: {{ $subject->name }} - {{ $test->name }}
@endsection

@section('category-header-text')
    Література {{ $subject->name }} - {{ $test->name }}:
@endsection

@section('main-container-class')
    @parent
    test-result
@endsection

@php
    /** @var \App\Models\Question[] $questions */
@endphp

@section('category-main-content')
    <div class="alert alert-info test-result-alert row" role="alert">
        <div class="col-sm-12">
            <p>Сумарно ви пройшли тест на <span class="h1">{{ $resultPercents }}%</span>.</p>
            <p>Ваша оцінка: {{ $resultMark }}</p>
        </div>
    </div>
    <div class="row mt-5 mb-3">
        <ul class="list-group text-dark questions col-12">
            @forelse ($questions as $question)
                <li class="list-group-item mb-4 question">
                    <h4 class="text-center">Примітка № {{ $loop->iteration }}</h4>

                    <div class="h5 no-drag">{!! $question->question !!}</div>

                    <div class="h4 mt-4 text-left">Література:</div>

                    <ul class="list-group">
                        @foreach($question->literatures as $literature)
                            <li class="list-group-item">{{ $literature }}</li>
                        @endforeach
                    </ul>
                </li>
            @empty
                <li class="list-group-item mb-4 question">
                    <h4>Немає літератури</h4>
                </li>
            @endforelse
        </ul>
    </div>
    <div class="btn-block d-flex justify-content-between pb-4">
        <a href="{{ route('client.tests') }}" class="btn btn-primary">До переліку тестів</a>
        <a href="javascript: void(0);" class="btn btn-primary" onclick="document.querySelector('.logout-link').click();">Вихід</a>
    </div>
@endsection

@include('blocks.scripts.no-scripts')
