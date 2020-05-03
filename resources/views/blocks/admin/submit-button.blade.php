<div class="form-row justify-content-between">
    @php
        $columnsMd = $columns ?? 9;
        $columnsSm = ($columnsMd !== 12) ? $columnsMd - 1 : 12;
        $columnsXs = ($columnsMd !== 12) ? $columnsSm - 1 : 12;
    @endphp

    <div class="col-{{ $columnsXs }} col-sm-{{ $columnsSm }} col-md-{{ $columnsMd }}">
        <button type="submit"
                class="btn btn-primary btn-block finish-test-btn mb-4 mt-3">{{ $slot }}</button>
    </div>
</div>
