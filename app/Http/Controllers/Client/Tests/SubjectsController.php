<?php

namespace App\Http\Controllers\Client\Tests;

use App\Http\Controllers\Client\ClientController;
use App\Lib\Words\Decliners\WordDeclinerInterface;
use App\Lib\Words\WordsManager;
use App\Models\TestSubject;
use App\Repositories\TestsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function showSingleSubject(TestsRepository $testsRepository)
    {
        $subject = $this->urlManager->getCurrentSubject();
        $this->authorize('pass-tests-of-subject', $subject);

        return view('pages.client.subjects-single', [
            'subject'        => $subject,
            'availableTests' => $testsRepository->testsForSelectingByUser(Auth::guard('client')->user()),
        ]);
    }
}
