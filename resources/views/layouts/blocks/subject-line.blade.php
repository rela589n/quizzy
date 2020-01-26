<li class="list-group-item d-flex justify-content-between align-items-center">
    <h3 class="category-header">{{ $subject['name'] }}</h3>

    <a href="{{ route($subjectRouteName, ['subject' => $subject['uri_alias'] ]) }}">Перейти</a>
    <span class="badge badge-primary badge-pill">{{ $subject['tests_count'] }}</span>
</li>
