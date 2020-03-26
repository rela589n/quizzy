@extends('layouts.main-skeleton', [
    'baseLayout' => 'layouts.root.admin'
])

@section('title')
    {{ $group->name }} - додати студента
@endsection

@section('content')
    {{ Breadcrumbs::render('admin.students.group.new', $group) }}
    @parent
@endsection

@section('main-container-content')
    @include('blocks.admin.student-form')
@endsection
