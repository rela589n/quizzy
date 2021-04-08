<li class="list-group-item d-flex justify-content-between align-items-center">
    <h3 class="category-header">{{ $header }}</h3>

    @isset($remainingAttemptsMessage)
        <span>({{ $remainingAttemptsMessage }})</span>
    @endisset

    <a href="{{ $link }}">{{ $linkText ?? 'Перейти' }}</a>

    @isset($badge)
        <span class="badge badge-primary badge-pill ml-3 ml-xl-0">{{ $badge }}</span>
    @endisset
</li>
