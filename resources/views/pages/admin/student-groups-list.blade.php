@extends('layouts.categories-single', ['baseLayout' => 'layouts.root.admin' ])

@section('category-header-text')
    Список груп студентів:
@endsection

@section('category-links')
    @forelse($groups as $group)
        @include('blocks.admin.student-group-line', ['group' => $group])
    @empty
        @component('layouts.blocks.empty-list-message')
            Немає жодної групи
        @endcomponent
    @endforelse
@endsection

@section('category-new-btn')
    @include('blocks.admin.create-new-link', [
        'link' => route('admin.students.new'),
        'text' => 'Створити групу'
    ])
@endsection
