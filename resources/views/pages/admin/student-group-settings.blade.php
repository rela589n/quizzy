@extends('layouts.main-skeleton', [
    'contentColumns' => 7,
    'baseLayout' => 'layouts.root.admin'
])

@section('title')
    {{ $group->name }} - налаштування
@endsection

@section('content')
    {{ Breadcrumbs::render('admin.students.group.settings', $group) }}
    @parent
@endsection

@section('main-container-content')
    @include('blocks.admin.student-group-form', [
      'submitButtonText' => 'Зберегти',
      'submitSize' => ($authUser->can('delete', $group)) ? 9 : 12
    ])

    @if($authUser->can('delete', $group))
        @include('blocks.admin.delete-entity-form')
    @endif
@endsection
