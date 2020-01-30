<li class="list-group-item d-flex justify-content-between align-items-center">
    <h3 class="category-header">{{ $test['name'] }}</h3>

    <a href="{{ route($testRouteName, ['subject' => $test->subject, 'test' => $test['uri_alias']]) }}">Перейти</a>
    <span class="badge badge-primary badge-pill">{{ $test['questions_count'] }}</span>
</li>
