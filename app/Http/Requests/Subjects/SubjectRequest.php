<?php

namespace App\Http\Requests\Subjects;

use App\TestSubject;
use Illuminate\Foundation\Http\FormRequest;

abstract class SubjectRequest extends FormRequest
{
    protected $currentSubject = null;

    /**
     * @return TestSubject | null
     */
    public function getCurrentSubject()
    {
        if ($this->currentSubject === null) {
            $this->currentSubject = $this->receiveCurrentSubject();
        }

        return $this->currentSubject;
    }


    protected function receiveCurrentSubject() {
        return TestSubject::where('uri_alias', '=', $this->route('subject'))->first();
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    abstract public function authorize();

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [];
    }
}
