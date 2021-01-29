<?php

declare(strict_types=1);


namespace App\Nova\Fields\Custom\Test;

use App\Models\MarkPercent;
use App\Models\Test;
use App\Services\Tests\Grading\GradingTableService;
use Fourstacks\NovaRepeatableFields\Repeater;
use Illuminate\Database\Eloquent\Collection;

final class GradingTableField
{
    public static function make()
    {
        return Repeater::make('Таблиця оцінювання')
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
                        'step'     => 0.01,
                        'required' => 'required',
                    ],
                ]
            )->resolveUsing(
                function ($value, Test $resource, $attribute) {
                    $marksPercents = $resource->marksPercents
                        ?? Collection::make();

                    return $marksPercents->toJson();
                }
            )->fillUsing(
                function ($request, $model, $attribute, $requestAttribute) {
                    $table = collect(json_decode($request->{$requestAttribute}, true));

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
