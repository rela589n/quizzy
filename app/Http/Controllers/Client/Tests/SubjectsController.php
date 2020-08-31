<?php

namespace App\Http\Controllers\Client\Tests;

use App\Http\Controllers\Client\ClientController;
use App\Models\TestSubject;
use App\Repositories\TestsRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
     * @return View
     * @throws AuthorizationException
     */
    public function showSingleSubject(TestsRepository $testsRepository): View
    {
        $subject = $this->urlManager->getCurrentSubject();
        $this->authorize('pass-tests-of-subject', $subject);

        return view('pages.client.subjects-single', [
            'subject'        => $subject,
            'availableTests' => $testsRepository->testsForSelectingByUser()
        ]);
    }
}
