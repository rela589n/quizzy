<?php

namespace App\Http\Controllers\Client\Tests;

use App\Http\Controllers\Client\ClientController;
use App\Models\TestSubject;
use App\Repositories\TestsRepository;
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
     * @param TestsRepository $testsRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function showSingleSubject(TestsRepository $testsRepository)
    {
        $subject = $this->urlManager->getCurrentSubject();
        $this->authorize('pass-tests-of-subject', $subject);

        return view('pages.client.subjects-single', [
            'subject'        => $subject,
            'availableTests' => $testsRepository->testsForSelectingByUser()
        ]);
    }
}
