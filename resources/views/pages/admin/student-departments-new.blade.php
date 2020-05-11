@extends('layouts.main-skeleton', [
    'contentColumns' => 7,
    'baseLayout' => 'layouts.root.admin'
])

@section('title')
     Створити відділення
@endsection

@section('content')
    {{ Breadcrumbs::render('admin.students.new') }}
    @parent
@endsection

@section('main-container-content')
    @include('blocks.admin.student-department-form')
@endsection
