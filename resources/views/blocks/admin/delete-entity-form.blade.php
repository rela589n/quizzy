@section('delete-entity-from')
    <form method="post" action="{{ $deleteFormAction ?? '' }}" class="clearfix">
        @method('delete')
        @csrf
        <button type="submit"
                class="btn btn-outline-danger finish-test-btn col-4 col-sm-3 col-md-2 float-right @error('delete') is-invalid @enderror"
                style="margin-top: -4.13rem;">{{ $deleteText ?? 'Видалити' }}
        </button>

        @error('delete')
        <span class="invalid-feedback">
            {{ $message }}
        </span>
        @enderror
    </form>
@show
