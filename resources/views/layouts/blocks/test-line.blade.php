@component('layouts.blocks.list-item-slot')
    <h3 class="category-header">{{ $test->name }}</h3>

    <a href="{{ route($testRouteName, ['subject' => $test->subject->uri_alias, 'test' => $test->uri_alias]) }}">Перейти</a>
    <span class="badge badge-primary badge-pill">{{ $test['questions_count'] }}</span>
@endcomponent
