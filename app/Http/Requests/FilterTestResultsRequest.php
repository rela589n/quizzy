<?php

namespace App\Http\Requests;

use App\Lib\ValidationGenerator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon as Carbon;

class FilterTestResultsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if ($this->has('resultDateIn')) {
            $this->merge([

                'resultDateIn' => array_map(function (string $date) {

                    return trim($date);
                }, explode(',', $this->input('resultDateIn')))
            ]);
        }
    }

    public function getQueryFilters()
    {
        $queryFilters = $this->only(['resultId', 'groupId', 'name', 'surname', 'patronymic', 'resultDateIn']);

        $queryFilters['resultDateIn'] = array_map(function (string $date) {

            return Carbon::createFromFormat('d.m.Y', trim($date));

        }, $queryFilters['resultDateIn'] ?? []);

        return $queryFilters;
    }

    public function getFilters()
    {
        return $this->only('result', 'mark');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @param ValidationGenerator $generator
     * @return array
     */
    public function rules(ValidationGenerator $generator)
    {
        $generator->setRequest($this);

        return $generator->buildManyRules([
            'resultId|groupId|surname|name|patronymic|result|mark|resultDateIn' => 'sometimes',

            'resultId|groupId'        => 'integer|min:1',
            'surname|name|patronymic' => 'string',
            'result'                  => 'numeric|between:0,100.0',
            'mark'                    => 'integer|min:1',
            'resultDateIn'            => 'array',
            'resultDateIn.*'          => 'date',
        ]);
    }
}
