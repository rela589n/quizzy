<?php

namespace App\Http\Requests\FilterTestResults;

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

    public function getQueryFilters(): array
    {
        $queryFilters = $this->only(['resultId', 'groupId', 'name', 'surname', 'patronymic', 'resultDateIn']);

        $queryFilters['resultDateIn'] = array_map(
            static function (string $date) {
                return Carbon::createFromFormat('d.m.Y', trim($date));
            },
            $queryFilters['resultDateIn'] ?? []
        );

        return $queryFilters;
    }

    public function getFilters(): array
    {
        return $this->only('result', 'mark');
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
                'resultId|groupId|surname|name|patronymic|result|mark|resultDateIn' => 'sometimes',

                'resultId|groupId'        => 'integer|min:1',
                'surname|name|patronymic' => 'string',
                'result'                  => 'numeric|between:0,100.0',
                'mark'                    => 'integer|min:1',
                'resultDateIn'            => 'array',
                'resultDateIn.*'          => 'date',
            ]
        );
    }
}
