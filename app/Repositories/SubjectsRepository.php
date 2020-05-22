<?php


namespace App\Repositories;


use App\Models\TestSubject;
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
}
