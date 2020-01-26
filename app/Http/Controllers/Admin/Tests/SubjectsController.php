<?php

namespace App\Http\Controllers\Admin\Tests;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubjectsRequest;

class SubjectsController extends Controller
{

    public function showNewSubjectForm()
    {
        return view('pages.admin.subjects-new');
    }

    public function newSubject(SubjectsRequest $request)
    {
        var_dump($request);
    }
}
