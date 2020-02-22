@extends('layouts.categories-list', ['baseLayout' => 'layouts.root.client' ])

@section('header')
    <h2 class="mb-4">Оберіть предмет тестування:</h2>
@endsection

@section('subject-links')
    @forelse($subjects as $subject)
        @include('blocks.client.subject-line', ['subject' => $subject])
    @empty
        @component('layouts.blocks.empty-list-message')
            Немає жодного доступного предмета тестування
        @endcomponent
    @endforelse
@endsection
