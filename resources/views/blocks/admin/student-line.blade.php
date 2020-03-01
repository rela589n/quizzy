@component('layouts.blocks.list-item-slot')
    <h3 class="category-header">{{ $student->full_name }}</h3>
    <a href="{{ route($studentRouteName, ['group' => $student->studentGroup->uri_alias, 'studentId' => $student->id]) }}">Перейти</a>
@endcomponent
