<?php

namespace App\Http\Requests\Subjects;

use App\TestSubject;
use Illuminate\Foundation\Http\FormRequest;

class SubjectRequest extends FormRequest
{
    protected $currentSubject = null;

    /**
     * @return TestSubject | null
     */
    public function getCurrentSubject()
    {
        if ($this->currentSubject === null) {
            $this->receiveCurrentSubject();
        }

        return $this->currentSubject;
    }


    protected function receiveCurrentSubject() {
        return TestSubject::where('uri_alias', '=', $this->route('subject'))->first();
    }
}
