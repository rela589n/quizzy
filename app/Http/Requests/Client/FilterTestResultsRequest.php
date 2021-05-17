<?php

namespace App\Http\Requests\Client;

use App\Lib\ValidationGenerator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class FilterTestResultsRequest extends FormRequest
{
    private ValidationGenerator $validationGenerator;

    public function authorize(): bool
    {
        return true;
    }

    public function attributes(): array
    {
        return $this->validationGenerator->buildAttribute(
            'resultDateIn.*',
            trans('validation.attributes.resultDateIn')
        );
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('resultDateIn')) {
            $this->merge(
                [
                    'resultDateIn' => array_map(
                        static function (string $date) {
                            return trim($date);
                        },
                        explode(',', $this->input('resultDateIn'))
                    )
                ]
            );
        }
    }

    public function getQueryFilterAttributes(): array
    {
        $queryFilters = $this->only(['resultId', 'subjectName', 'testName', 'resultDateIn', 'result', 'mark']);

        $queryFilters['resultDateIn'] = array_map(
            static function (string $date) {
                return Carbon::createFromFormat('d.m.Y', trim($date));
            },
            $queryFilters['resultDateIn'] ?? []
        );

        return $queryFilters;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @param  ValidationGenerator  $generator
     * @return array
     */
    public function rules(ValidationGenerator $generator): array
    {
        $this->validationGenerator = $generator;
        $generator->setRequest($this);

        return $generator->buildManyRules(
            [
                'resultId|subjectName|testName|result|mark|resultDateIn' => 'sometimes',

                'resultId' => 'integer|min:1',
                'subjectName|testName' => 'string',
                'result' => 'numeric|between:0,100.0',
                'mark' => 'integer|min:1',
                'resultDateIn' => 'array',
                'resultDateIn.*' => 'date',
            ]
        );
    }
}
