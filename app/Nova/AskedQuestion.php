<?php

declare(strict_types=1);

namespace App\Nova;

use App\Models\AskedQuestion as AskedQuestionModel;
use App\Models\AskedQuestions\AskedQuestionsEloquentBuilder;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

final class AskedQuestion extends Resource
{
    public static $model = AskedQuestionModel::class;

    public static $title = 'id';

    public static $search = [
        'id'
    ];

    public static $perPageViaRelationship = 80;

    /**
     * @param  NovaRequest  $request
     * @param  AskedQuestionsEloquentBuilder  $query
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->withRightAnswersCount()
            ->withCount('answers')
            ->with('question');
    }

    protected static function applyOrderings($query, array $orderings)
    {
        if (!empty($orderings)) {
            return parent::applyOrderings($query, $orderings);
        }

        return $query->orderBy('id');
    }

    public function fields(Request $request)
    {
        return [
            ID::make(),


            BelongsTo::make(__('Question'), 'question', Question::class),

            Text::make(
                'Правильно / Всього',
                function (AskedQuestionModel $askedQuestion) {
                    return "{$askedQuestion->right_answers_count} / {$askedQuestion->answers_count}";
                }
            ),

            Boolean::make(
                'Зараховано',
                function (AskedQuestionModel $askedQuestion) {
                    return $askedQuestion->right_answers_count === $askedQuestion->answers_count;
                }
            ),

            HasMany::make(__('Answers'), 'answers', Answer::class),

            BelongsTo::make(__('TestResult'), 'testResult', TestResult::class),
        ];
    }

    public static function authorizedToCreate(Request $request)
    {
        return false;
    }

    public function authorizedToDelete(Request $request)
    {
        return false;
    }

    public function authorizedToUpdate(Request $request)
    {
        return false;
    }

    public function cards(Request $request)
    {
        return [];
    }

    public function filters(Request $request)
    {
        return [];
    }

    public function lenses(Request $request)
    {
        return [];
    }

    public function actions(Request $request)
    {
        return [];
    }
}
