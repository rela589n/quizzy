<?php


namespace App\Models\Query;


use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\Grammars\Grammar;
use Illuminate\Database\Query\Processors\Processor;
use Illuminate\Support\Arr;

/** @mixin \Illuminate\Database\Eloquent\Builder */
final class CustomBuilder extends Builder
{
    public function __construct(ConnectionInterface $connection, Grammar $grammar = null, Processor $processor = null)
    {
        parent::__construct($connection, $grammar, $processor);
    }

    // this doesn't give us performance enhancement
    private bool $tryOptimizeWhereIntegerInRaw = false;

    private const OPTIMIZE_RUN = 8;

    /**
     * @param  string  $column
     * @param  array|Arrayable  $values
     * @param  string  $boolean
     * @param  false  $not
     * @return CustomBuilder
     */
    public function whereIntegerInRaw($column, $values, $boolean = 'and', $not = false)
    {
        if ($values instanceof Arrayable) {
            $values = $values->toArray();
        }

        if (!$this->tryOptimizeWhereIntegerInRaw
            || $not !== false
            || count($values) <= self::OPTIMIZE_RUN
        ) {
            return parent::whereIntegerInRaw($column, $values, $boolean, $not);
        }

        $this->tryOptimizeWhereIntegerInRaw = false;

        $values = array_map(static fn($value) => (int)$value, $values);

        sort($values);

        $iMax = count($values);

        $groups = [
            [
                'start' => 0,
                'end'   => $iMax - 1, // probably will be overridden
            ]
        ];

        for ($i = 1; $i < $iMax; ++$i) {
            if ($values[$i] - $values[$i - 1] <= 1) {
                // 0 or 1
                continue;
            }

            end($groups);
            $groups[key($groups)]['end'] = $i - 1;

            $groups[] = [
                'start' => $i,
                'end'   => $iMax - 1,
            ];
        }

        $valuesForSimpleQuery = array_filter(
            $groups,
            static fn(array $group) => $group['end'] - $group['start'] <= self::OPTIMIZE_RUN
        );
        $valuesForSimpleQuery = Arr::flatten(
            array_map(
                static fn(array $group) => range($values[$group['start']], $values[$group['end']]),
                $valuesForSimpleQuery
            )
        );

        $groupsForOptimization = array_filter(
            $groups,
            static fn(array $group) => $group['end'] - $group['start'] > self::OPTIMIZE_RUN
        );

        $groupsForOptimization = array_map(
            static fn(array $group) => [
                $values[$group['start']],
                $values[$group['end']],
            ],
            $groupsForOptimization
        );

        $this->where(
            function (self $query) use ($values, $valuesForSimpleQuery, $column, &$groupsForOptimization) {
                $query->tryOptimizeWhereIntegerInRaw = false;
                $query->whereIntegerInRaw($column, $valuesForSimpleQuery);
                $query->tryOptimizeWhereIntegerInRaw = true;

                foreach ($groupsForOptimization as $group) {
                    $query->whereBetween($column, $group, 'or');
                }

                $this->tryOptimizeWhereIntegerInRaw = true;
            }
        );

        return $this;
    }

    /**
     * @param $column
     *
     * @return $this
     */
    public function appendSelect($column): self
    {
        if (is_null($this->columns)) {
            $this->select([$this->from.'.*']);
        }

        return $this->addSelect($column);
    }

    /**
     * @param  \Closure|\Illuminate\Database\Query\Builder|string  $query
     * @param  string  $as
     *
     * @return $this
     */
    public function appendSelectSub($query, string $as): self
    {
        if (is_null($this->columns)) {
            $this->select([$this->from.'.*']);
        }

        return $this->selectSub($query, $as);
    }
}
