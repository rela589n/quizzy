<?php

namespace App\Http\Controllers\Client\Tests;

use App\Http\Controllers\Client\ClientController;
use App\Models\TestSubject;
use Illuminate\Http\Request;

class SubjectsController extends ClientController
{
    public function showAll(Request $request)
    {
        return view('pages.client.subjects-list', [
            'subjects' => TestSubject::withCount('tests')->get()
        ]);
    }

    public function showSingleSubject()
    {
        $subject = $this->urlManager->getCurrentSubject();

        // necessary to remove duplicated queries
        $subject->tests->loadMissing('testComposites');
        $subject->tests->each(function($result) {
            $result->questions_count = $result->allQuestions()->count();
        });

        return view('pages.client.subjects-single', [
            'subject' => $subject
        ]);
    }
}
