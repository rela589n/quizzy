@extends('layouts.main-skeleton', [
    'baseLayout' => 'layouts.root.admin'
])

@section('title')
    {{ $user->studentGroup->name }} - {{ $user->full_name }}
@endsection

@section('content')
    {{ Breadcrumbs::render('admin.students.department.group.student', $user) }}
    @parent
@endsection

@section('main-container-content')
    @include('blocks.admin.student-info')
@endsection
