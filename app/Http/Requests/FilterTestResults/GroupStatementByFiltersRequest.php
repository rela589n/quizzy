<?php


namespace App\Http\Requests\FilterTestResults;


use App\Lib\ValidationGenerator;

class GroupStatementByFiltersRequest extends FilterTestResultsRequest
{
    public function rules(ValidationGenerator $generator): array
    {
        $rules = parent::rules($generator);

        if (($key = array_search('sometimes', $rules['groupId'], true)) !== false) {
            unset($rules['groupId'][$key]);
        }

        array_unshift($rules['groupId'], 'required');

        return $rules;
    }
}
