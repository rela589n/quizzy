<?php


namespace App\Models\TestResults;


use App\Lib\Filters\Eloquent\ResultFilter;
use App\Lib\Traits\FilteredScope;
use App\Models\Test;
use App\Models\TestResult;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/** @mixin TestResult */
class TestResultQueryBuilder extends Builder
{
    use FilteredScope {
        scopeFiltered as private;
    }

    public function ofTest($test): self
    {
        $testId = is_numeric($test) ? $test : $test->id;

        return $this->whereHas(
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

    public function recent($count): self
    {
        return $this->latest()->limit($count);
    }

    /**
     * @param  ResultFilter  $filters
     * @param  callable|null  $callback
     *
     * @return Collection|TestResult[]
     */
    public function filtered(ResultFilter $filters, callable $callback = null): Collection
    {
        return $this->scopeFiltered($this, $filters, $callback);
    }

    public function withResultPercents(): self
    {
        return $this->addSelect(
            $this->raw('test_result_in_percents(test_results.id) as result_percents')
        );
    }

    public function whereMarkPercentBetween(float $min, float $max): self
    {
        return $this->whereRaw("test_result_in_percents(test_results.id) between $min and $max");
    }

    public function whereMarkPercentAtLeast(float $min): self
    {
        return $this->whereRaw("test_result_in_percents(test_results.id) >= $min");
    }

    public function whereMarkPercentAtMost(float $max): self
    {
        return $this->whereRaw("test_result_in_percents(test_results.id) <= $max");
    }
}
