@extends('layouts.main-skeleton', [
    'baseLayout' => 'layouts.root.admin'
])

@section('title')
    {{ $subject->name  }} - додати тест
@endsection

@section('content')
    {{ Breadcrumbs::render('admin.tests.subject.new', $subject) }}
    @parent
@endsection

@section('main-container-content')
    @include('blocks.admin.test-form', ['submitButtonText' => 'Створити'])
@endsection
