<?php

namespace App\Http\Controllers\Admin\Tests;

use App\Http\Controllers\Controller;
use App\Http\Requests\Subjects\NewSubjectRequest;
use App\Http\Requests\Subjects\UpdateSubjectRequest;
use App\TestSubject;
use Illuminate\Http\Request;

class SubjectsController extends Controller
{

    public function showNewSubjectForm()
    {
        return view('pages.admin.subjects-new');
    }

    public function showAll()
    {
        return view('pages.admin.subjects-list', [
            'subjects' => TestSubject::withCount('tests')->get()
        ]);
    }

    public function newSubject(NewSubjectRequest $request)
    {
        $validated = $request->validated();
        TestSubject::create($validated);

        return redirect()->route('admin.tests.subject', [
            'subject' => $validated['uri_alias']
        ]);
    }

    public function showUpdateSubjectForm(Request $request)
    {
        return view('pages.admin.subjects-single-settings', [
            'subject' => TestSubject::where('uri_alias', '=', 'check')->first()
        ]);
    }

    public function updateSubject(UpdateSubjectRequest $request)
    {
        $subject = $request->getCurrentSubject();
        $subject->update($request->validated());

        return redirect()->route('admin.tests.subject',[
            'subject' => $subject['uri_alias']
        ]);
    }
}
