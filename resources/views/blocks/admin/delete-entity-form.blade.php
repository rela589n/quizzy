@section('delete-entity-from')
    <form method="post" action="{{ $deleteFormAction ?? '' }}" class="clearfix">
        @method('delete')
        @csrf
        <button type="submit" class="btn btn-outline-danger finish-test-btn col-2 float-lg-right float-md-none"
                style="margin-top: -4.13rem;">{{ $deleteText ?? 'Видалити' }}
        </button>
    </form>
@show
