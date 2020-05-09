@extends('layouts.main-skeleton', [
    'baseLayout' => 'layouts.root.admin'
])

@section('title')
    {{ $group->name }} - додати студента
@endsection

@section('content')
    {{ Breadcrumbs::render('admin.students.department.group.new', $department, $group) }}
    @parent
@endsection

@section('main-container-content')
    @include('blocks.admin.student-form')
@endsection
