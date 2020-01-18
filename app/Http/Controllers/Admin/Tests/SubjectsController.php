<?php

namespace App\Http\Controllers\Admin\Tests;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubjectsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
