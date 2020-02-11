<?php

namespace App\Http\Controllers\Client\Tests;

use App\Http\Controllers\Controller;
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
}
