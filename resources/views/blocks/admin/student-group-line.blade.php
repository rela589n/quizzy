@component('layouts.blocks.list-item-slot')
    <h3 class="category-header">{{ $group['name'] }}</h3>

    <a href="{{ route('admin.students.group', ['group' => $group['uri_alias'] ]) }}">Перейти</a>
    <span class="badge badge-primary badge-pill">{{ $group['students_count'] }}</span>
@endcomponent
