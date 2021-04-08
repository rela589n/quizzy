<?php


namespace App\Services\Tests;


use App\Lib\Filters\Common\IncludeTestsFilter;
use App\Lib\Transformers\Collection\IncludeTestsTransformer;
use App\Models\Test;
use App\Models\TestSubject;
use Illuminate\Support\Collection;

abstract class StoreTestService
{
    public const NEW_TEST_INCLUDE_QUANTITY = 999;

    protected IncludeTestsFilter $filter;
    protected IncludeTestsTransformer $transformer;
    protected array $fields = [];
    protected Test $test;

    public function __construct(
        IncludeTestsFilter $filter,
        IncludeTestsTransformer $transformer
    ) {
        // todo use GradingTableService
        $this->filter = $filter;
        $this->transformer = $transformer;
    }

    /**
     * @param  TestSubject  $subject
     * @return $this
     */
    public function ofSubject(TestSubject $subject): self
    {
        $this->fields['test_subject_id'] = $subject->id;

        return $this;
    }

    public function handle(array $request): Test
    {
        $this->fields = array_merge($request, $this->fields);

        $this->test = $this->doHandle();
        $this->handleInclude(collect($this->fields['include'] ?? []));
        $this->handleCustomEvaluation(collect($this->fields['correlation_table'] ?? []));

        return $this->test;
    }

    protected function handleInclude(Collection $include): void
    {
        $include = $this->applyIncludeFilters($include);
        $include = $this->applyIncludeTransforming($include);

        $this->syncIncludeTests($include);
    }

    protected function applyIncludeFilters(Collection $include): Collection
    {
        return $this->filter->apply($include);
    }

    protected function applyIncludeTransforming(Collection $include): Collection
    {
        return $this->transformer->transform($include);
    }

    protected function syncIncludeTests(Collection $include): void
    {
        $this->test->tests()->sync($include);
    }

    protected function handleCustomEvaluation(Collection $collection): void
    {
        $this->detachMarkPercents();
        $this->prepareMarkPercents($collection);
        $this->saveMarkPercents($collection);
    }

    protected function detachMarkPercents(): void
    {
        $this->test->marksPercents()->delete();
    }

    protected function prepareMarkPercents(Collection &$collection): void
    {
        $collection = $collection->sortBy(
            static function ($element) {
                return (int)$element['mark'];
            }
        );
    }

    protected function saveMarkPercents(Collection $collection): void
    {
        $this->test->marksPercents()->createMany($collection);
    }

    abstract protected function doHandle(): Test;
}
