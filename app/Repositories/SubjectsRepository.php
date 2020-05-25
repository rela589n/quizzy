<?php


namespace App\Repositories;


use App\Models\Test;
use App\Models\TestSubject;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;

class SubjectsRepository
{
    public function subjectsToInclude()
    {
        return TestSubject::with(['tests' => function (Relation $query) {
            $query->has('nativeQuestions')
                ->withCount('nativeQuestions as questions_count');
        }])->get();
    }

    public function subjectsForResults()
    {
        return TestSubject::whereHas('tests', function (Builder $query) {
            /**
             * @var $query Builder|Test
             */

            $query->withTrashed();
            $query->has('testResults');
        })->get();
    }
}
