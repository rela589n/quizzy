@extends('layouts.main-skeleton', [
    'contentColumns' => 7,
    'baseLayout' => 'layouts.root.admin'
])

@section('title')
    {{ $department->name }} - Налаштування
@endsection

@section('content')
    {{ Breadcrumbs::render('admin.students.department.settings', $department) }}
    @parent
@endsection

@section('main-container-content')
    @include('blocks.admin.student-department-form', [
      'submitButtonText' => 'Зберегти',
      'submitSize' => ($authUser->can('delete', $department)) ? 9 : 12
    ])

    @if($authUser->can('delete', $department))
        @include('blocks.admin.delete-entity-form')
    @endif
@endsection
