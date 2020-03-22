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
            'subjects' => TestSubject::availableFor($request->user())
                ->withCount('tests')
                ->get()
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function showSingleSubject()
    {
        $subject = $this->urlManager->getCurrentSubject();
        $this->authorize('pass-tests-of-subject', $subject);

        // necessary to remove duplicated queries
        $subject->tests->loadMissing('testComposites');
        $subject->tests->each(function ($test) {
            $test->questions_count = $test->allQuestions()->count();
        });

        return view('pages.client.subjects-single', [
            'subject' => $subject
        ]);
    }
}
