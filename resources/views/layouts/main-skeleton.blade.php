@extends($baseLayout)

@section('content')
    <div class="@section('main-container-class') {{ $mainContainerType ?? 'container' }} mt-5 @show">
        <div class="row">
            @php
                $contentXl = $contentColumns ?? 8;
                $contentLg = min($contentXl + 1, 12);
                $contentMd = min($contentLg + 3, 12)
            @endphp

            <div class="col-12 col-md-{{ $contentMd }} col-lg-{{ $contentLg }} col-xl-{{ $contentXl }} m-auto">
                @yield('main-container-content')
            </div>
        </div>
    </div>
@endsection

@isset($messageToUser)
@section('bottom-scripts')
    @parent
    <script>
        window.backEndMessage = {!! json_encode($messageToUser) !!};
    </script>
    <script defer src="{{ asset('js/show-popup.js') }}"></script>
@endsection
@endisset
