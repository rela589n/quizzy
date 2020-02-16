<?php

namespace App\Http\Controllers\Client\Tests;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestUrlManager;
use App\Models\TestSubject;
use Illuminate\Http\Request;

class SubjectsController extends Controller
{
    public function showAll(Request $request)
    {
        return view('pages.client.subjects-list', [
            'subjects' => TestSubject::withCount('tests')->get()
        ]);
    }

    public function showSingleSubject(RequestUrlManager $urlManager)
    {
        $subject = $urlManager->getCurrentSubject();

        // to remove duplicated queries
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
