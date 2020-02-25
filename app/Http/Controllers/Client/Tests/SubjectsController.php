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

        // because in view we use $test->subject->uri_alias, which cause duplicated queries
        $subject->tests->loadMissing('subject');

        return view('pages.client.subjects-single', [
            'subject' => $subject
        ]);
    }
}
