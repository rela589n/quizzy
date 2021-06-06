<?php


namespace App\Lib\Filters\Eloquent;


use App\Models\StudentGroup;
use App\Models\TestResults\TestResultQueryBuilder;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Carbon;

use function method_exists;

class TestResultFilter extends ResultFilter
{
    protected array $queryFilters = [];
    protected array $filters = [];

    public function setQueryFilters(array $queryFilters): self
    {
        $this->queryFilters = $queryFilters;

        return $this;
    }

    public function setFilters(array $filters): self
    {
        $this->filters = $filters;

        return $this;
    }

    protected function loadRelations(EloquentCollection $results): void
    {
        $results->loadMissing(
            [
                'askedQuestions.question' => static function (Relation $query) {
                    $query->withTrashed();
                },
                'askedQuestions.answers.answerOption' => static function (Relation $query) {
                    $query->withTrashed();
                },
                'user' => static function (Relation $query) {
                    $query->withTrashed();
                },
                'user.studentGroup' => static function (Relation $query) {
                    $query->withTrashed();
                }
            ]
        );
    }

    protected function filterFilters(array $arr)
    {
        return array_filter(
            $arr,
            static function ($val) {
                return $val !== '' && $val !== null && $val !== [];
            }
        );
    }

    protected function filters(): array
    {
        return $this->filterFilters($this->filters);
    }

    protected function queryFilters(): array
    {
        return $this->filterFilters($this->queryFilters);
    }

    /**
     * @param  EloquentBuilder  $query
     * @param $value
     */
    public function resultId($query, $value): void
    {
        $query->where('id', $value);
    }

    /**
     * @param  EloquentBuilder  $query
     * @param $groupId
     */
    public function groupId($query, $groupId): void
    {
        $query->whereHas(
            'user',
            static function (EloquentBuilder $userBuilder) use ($groupId) {
                /**
                 * @var EloquentBuilder|User $userBuilder
                 */
                $userBuilder->withTrashed();

                $userBuilder->whereHas(
                    'studentGroup',
                    static function (EloquentBuilder $groupBuilder) use ($groupId) {
                        /**
                         * @var EloquentBuilder|StudentGroup $groupBuilder
                         */
                        $groupBuilder->withTrashed();
                        $groupBuilder->where('id', $groupId);
                    }
                );
            }
        );
    }

    /**
     * @param  string  $relation
     * @param  EloquentBuilder  $query
     * @param  string  $field
     * @param $fieldValue
     */
    protected function textFieldFilter(string $relation, $query, string $field, $fieldValue): void
    {
        $query->whereHas(
            $relation,
            static function (EloquentBuilder $builder) use ($field, $fieldValue) {
                /** @var Model|EloquentBuilder $builder */
                if (method_exists($builder, 'withTrashed')) {
                    $builder->withTrashed();
                }

                $builder->where($field, 'like', "%$fieldValue%");
            }
        );
    }

    /**
     * @param  EloquentBuilder  $query
     * @param $name
     */
    public function name($query, $name): void
    {
        $this->textFieldFilter('user', $query, 'name', $name);
    }

    /**
     * @param  EloquentBuilder  $query
     * @param $surname
     */
    public function surname($query, $surname): void
    {
        $this->textFieldFilter('user', $query, 'surname', $surname);
    }

    /**
     * @param  EloquentBuilder  $query
     * @param $patronymic
     */
    public function patronymic($query, $patronymic): void
    {
        $this->textFieldFilter('user', $query, 'patronymic', $patronymic);
    }

    /**
     * @param  EloquentBuilder  $query
     * @param  Carbon[]  $dates
     */
    public function resultDateIn($query, $dates): void
    {
        $query->where(
            static function (EloquentBuilder $query) use ($dates) {
                array_map(
                    static function (Carbon $date) use ($query) {
                        $query->orWhereDate('created_at', $date);
                    },
                    $dates
                );
            }
        );
    }

    /** @param  TestResultQueryBuilder */
    public function testName($query, $testName): void
    {
        $this->textFieldFilter('test', $query, 'name', $testName);
    }

    /** @param  TestResultQueryBuilder  $query */
    public function subjectName($query, $subjectName): void
    {
        $this->textFieldFilter('test.subject', $query, 'name', $subjectName);
    }

    public function result($testResult, $score): bool
    {
        return abs(100 * $testResult->score - $score) <= 5;
    }

    public function mark($testResult, $mark): bool
    {
        return $testResult->mark == $mark;
    }
}
