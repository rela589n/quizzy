@component('layouts.blocks.list-item-slot')
    <h3 class="category-header">{{ $usersType }}</h3>

    <a href="{{ $typeUrl  }}">Перейти</a>
    <span class="badge badge-primary badge-pill">{{ $usersCount }}</span>
@endcomponent
