@extends('layouts.main-skeleton', [
    'contentColumns' => 7,
    'baseLayout' => 'layouts.root.admin'
])

@section('title')
    Додати новий предмет
@endsection

@section('content')
    {{ Breadcrumbs::render('admin.tests.new') }}
    @parent
@endsection

@section('main-container-content')
    @include('blocks.admin.subject-form')
@endsection
