<?php

declare(strict_types=1);


namespace App\Nova\Fields\Custom\Test;

use App\Models\MarkPercent;
use App\Models\Test;
use App\Rules\Containers\Test\TestGradingTableRules;
use App\Services\Tests\Grading\GradingTableService;
use Fourstacks\NovaRepeatableFields\Repeater;
use Illuminate\Database\Eloquent\Collection;

final class GradingTableField
{
    public static function make()
    {
        return Repeater::make('Таблиця оцінювання', 'correlation_table')
            ->rules((new TestGradingTableRules())->usingJson())
            ->initialRows(1)
            ->addField(
                [
                    'label'      => 'Оцінка',
                    'name'       => 'mark',
                    'type'       => 'number',
                    'attributes' => [
                        'required' => 'required',
                    ],
                ]
            )
            ->addField(
                [
                    'label'      => 'Відсоток',
                    'name'       => 'percent',
                    'type'       => 'number',
                    'attributes' => [
                        'step' => 0.01,
                        'required' => 'required',
                        'max' => 100,
                    ],
                ]
            )->resolveUsing(
                function ($value, Test $resource, $attribute) {
                    $marksPercents = $resource->marksPercents ?? collect();

                    return $marksPercents->toJson();
                }
            )->fillUsing(
                function ($request, $model, $attribute, $requestAttribute) {
                    $table = collect(
                        optional(
                            $request->{$requestAttribute},
                            static fn($json) => json_decode($json, true)
                        ) ?? []
                    );

                    $table = Collection::make(
                        $table->map(
                            function ($attrs) {
                                return new MarkPercent($attrs);
                            }
                        )
                    );

                    resolve(GradingTableService::class)->attachForTest($model, $table);
                }
            );
    }
}
