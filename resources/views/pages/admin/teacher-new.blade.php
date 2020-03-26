@extends('layouts.main-skeleton', [
    'baseLayout' => 'layouts.root.admin'
])

@section('title')
    Додати адміністратора
@endsection

@section('content')
    {{ Breadcrumbs::render('admin.teachers.new') }}
    @parent
@endsection

@section('main-container-content')
    @include('blocks.admin.teacher-form')
@endsection
