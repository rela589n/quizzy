@extends('layouts.categories-single', [
    'baseLayout' => 'layouts.root.client',
    'contentColumns' => 8
])

@php
    /** @var \App\Models\Test $test */
    /** @var \App\Models\TestSubject $subject */
@endphp

@section('title')
    Результати: {{ $subject->name }} - {{ $test->name }}
@endsection

@section('category-header-text')
    Результати тестування {{ $subject->name }} - {{ $test->name }}:
@endsection

@section('main-container-class')
    @parent
    test-result
@endsection

@section('category-main-content')
    <div class="alert alert-info test-result-alert row" role="alert">
        <div class="col-md-9 col-sm-12">
            <p>Сумарно ви пройшли тест на <span class="h1">{{ $resultPercents }}%</span>.</p>
            <p>Ваша оцінка: {{ $resultMark }}</p>
        </div>
        @if($test->output_literature)
            <div class="col-md-3 col-sm-12 text-right">
                <div>
                    <a href="{{ action(
                                    [\App\Http\Controllers\Client\Tests\TestsController::class, 'showLiteraturePage'],
                                     ['subject' => $subject->uri_alias, 'test' => $test->uri_alias, 'result' => $resultId])
                              }}"
                       class="btn btn-sm btn-info">Література</a>
                </div>
            </div>
        @endif
    </div>
    <div class="btn-block d-flex justify-content-between">
        <a href="{{ route('client.tests') }}" class="btn btn-primary">До переліку тестів</a>
        <a href="javascript: void(0);" class="btn btn-primary" onclick="document.querySelector('.logout-link').click();">Вихід</a>
    </div>
@endsection

@include('blocks.scripts.no-scripts')
