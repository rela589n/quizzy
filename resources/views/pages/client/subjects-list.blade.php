@extends('layouts.categories-single', ['baseLayout' => 'layouts.root.client' ])

@section('category-header-text')
    Оберіть предмет тестування:
@endsection

@section('category-links')
    @forelse($subjects as $subject)
        @include('blocks.client.subject-line', ['subject' => $subject])
    @empty
        @component('layouts.blocks.empty-list-message')
            Немає жодного доступного предмета тестування
        @endcomponent
    @endforelse
@endsection
