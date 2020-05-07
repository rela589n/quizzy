@extends('layouts.categories-single', ['baseLayout' => 'layouts.root.admin' ])

@section('title')
    Результати - вибір предмета
@endsection

@section('content')
    {{ Breadcrumbs::render('admin.results') }}
    @parent
@endsection

@section('category-header-text')
    Оберіть предмет:
@endsection

@section('category-links')
    @forelse($subjects as $subject)
        @include('blocks.entity-line', [
            'header' => $subject->name,
            'link' => route('admin.results.subject', ['subject' => $subject->uri_alias ]),
            'badge' => $subject->results_count
        ])
    @empty
        @component('layouts.blocks.empty-list-message')
            Немає предметів, що містили б результати
        @endcomponent
    @endforelse
@endsection

@include('blocks.scripts.no-scripts')
