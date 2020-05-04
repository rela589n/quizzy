<?php


namespace App\Repositories;


use App\Models\TestSubject;

class SubjectsRepository
{
    public function subjectsToInclude()
    {
        return TestSubject::with(['tests' => function ($query) {
            $query->has('nativeQuestions')
                ->withCount('nativeQuestions as questions_count');
        }])->get();
    }
}
