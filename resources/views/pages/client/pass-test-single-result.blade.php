@extends('layouts.categories-single', [
    'baseLayout' => 'layouts.root.client',
    'contentColumns' => 8
])

@section('category-header-text')
    Результати тестування {{ $subject->name }} - {{ $test->name }}:
@endsection

@section('category-class')
    container mt-5 test-result
@endsection

@section('category-main-content')
    <div class="alert alert-info test-result-alert" role="alert">
        <p>Суммарно ви пройшли тест на <span class="h1">{{ $resultPercents }}%</span>.</p>
        <p>Ваша оцінка: {{ $resultMark }}</p>
    </div>
    <div class="btn-block" style="display: flex;justify-content: space-between;">
        <a href="{{ route('client.tests') }}" class="btn btn-primary">До переліку тестів</a>
        <a href="javascript: void(0);" class="btn btn-primary" onclick="document.querySelector('.logout-link').click();">Вихід</a>
    </div>
@endsection
