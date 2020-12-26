<?php


namespace App\Models\TestResults;


use App\Lib\Filters\Eloquent\ResultFilter;
use App\Lib\Traits\FilteredScope;
use App\Models\Test;
use App\Models\TestResult;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * @method static Builder|TestResult ofTest($testId)
 * @method static Builder|TestResult recent($count)
 * @method static Builder|TestResult|Collection filtered(ResultFilter $filters)
 */
final class TestResultQueryBuilder extends Builder
{
    use FilteredScope;

    /**
     * @param  Builder  $query
     * @param  int | Test  $test
     * @return Builder|TestResult
     */
    public function scopeOfTest($query, $test): Builder
    {
        $testId = is_numeric($test) ? $test : $test->id;

        return $query->whereHas(
            'test',
            static function (Builder $query) use ($testId) {
                /**
                 * @var Builder|Test $query
                 */

                $query->withTrashed();
                $query->where('id', $testId);
            }
        );
    }

    /**
     * @param  Builder|TestResult  $query
     * @param $count
     * @return Builder
     */
    public function scopeRecent($query, $count)
    {
        return $query->latest()->limit($count);
    }
}
