@component('layouts.blocks.list-item-slot')
    <h3 class="category-header">{{ $teacher->full_name }}</h3>
    <a href="{{ route($teacherRouteName, ['teacherId' => $teacher->id]) }}">Перейти</a>
@endcomponent
