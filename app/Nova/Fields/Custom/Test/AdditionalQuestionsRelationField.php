<?php

declare(strict_types=1);

namespace App\Nova\Fields\Custom\Test;

use App\Nova\Test;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Http\Requests\ResourceDetailRequest;

final class AdditionalQuestionsRelationField
{
    public static function make(Test $_this)
    {
        return BelongsToMany::make('Вибірка запитань', 'tests', Test::class)
            ->singularLabel('Вибірку запитань')
            ->fields(
                fn() => [
                    Number::make('К-сть Запитань', 'questions_quantity')
                        ->displayUsing(
                            function ($includeCount) use ($_this) {
                                $totalCount = $_this->resource->native_questions_count
                                    ?? ($_this->resource->getRelation('nativeQuestions') ?: collect())->count();

                                return "$includeCount / $totalCount";
                            }
                        )
                        ->placeholder('')
                        ->min(1)
                        ->max(999)
                ]
            )->showOnDetail(
                function (ResourceDetailRequest $request, \App\Models\Test $resource) {
                    return $resource->type === \App\Models\Test::TYPE_COMPOSED;
                }
            )->searchable();
    }
}
