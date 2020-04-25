@extends('layouts.categories-single', ['baseLayout' => 'layouts.root.admin' ])

@section('title')
    Список адміністраторів
@endsection

@section('content')
    {{ Breadcrumbs::render('admin.teachers') }}
    @parent
@endsection

@section('category-header-text')
    Список адміністраторів:
@endsection

@section('category-links')
    @forelse($teachers as $teacher)
        @include('blocks.entity-line', [
            'header' => $teacher->full_name,
            'link' => route('admin.teachers.teacher', ['teacherId' => $teacher->id]),
        ])
    @empty
        @component('layouts.blocks.empty-list-message')
            Додайте викладача натиснувши кнопку нижче:
        @endcomponent
    @endforelse
@endsection


@section('category-new-btn')
    @if ($authUser->can('create-administrators'))
        @include('blocks.admin.create-new-link', [
            'link' => route('admin.teachers.new'),
            'text' => 'Створити нового'
        ])
    @endif
@endsection

