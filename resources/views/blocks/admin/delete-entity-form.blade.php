@section('delete-entity-from')
    <form method="post" action="{{ $deleteFormAction ?? '' }}" class="clearfix">
        @method('delete')
        @csrf
        <button type="submit"
                class="btn btn-outline-danger finish-test-btn col-2 float-lg-right float-md-none @error('delete') is-invalid @enderror"
                style="margin-top: -4.13rem;">{{ $deleteText ?? 'Видалити' }}
        </button>

        @error('delete')
        <span class="invalid-feedback">
            {{ $message }}
        </span>
        @enderror
    </form>
@show
