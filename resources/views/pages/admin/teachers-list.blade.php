@extends('layouts.categories-single', ['baseLayout' => 'layouts.root.admin' ])

@section('category-header-text')
    Список викладачів:
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
    @include('blocks.admin.create-new-link', [
        'link' => route('admin.teachers.new'),
        'text' => 'Створити нового'
    ])
@endsection

