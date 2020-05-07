@section('alias-label')
    <label for="alias" class="form-info mb-4 h3">
        {{ $aliasText ?? 'Введіть псевдонім для використання в uri:' }}
    </label>
@show

<div class="form-group form-row align-items-start">
    <div class="col-8 col-sm-9">
        <input id="alias" name="uri_alias" type="text" class="form-control @error('uri_alias') is-invalid @enderror"
               placeholder="Псевдонім"
               required="required" value="{{ old('uri_alias', $aliasable->uri_alias ?? '') }}">

        @error('uri_alias')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="col-4 col-sm-3">
        <button tabindex="-1" type="button" id="auto-generate-translit" class="btn btn-primary btn-block"
                disabled="disabled">Автоматично
        </button>
    </div>
</div>

@section('bottom-scripts')
    @parent
    @include('blocks.scripts.translit-uri')
@endsection
