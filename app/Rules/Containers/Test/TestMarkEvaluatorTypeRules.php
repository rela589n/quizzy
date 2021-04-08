<?php

declare(strict_types=1);


namespace App\Rules\Containers\Test;

use App\Models\Test;
use App\Rules\Containers\RulesContainer;
use Illuminate\Validation\Rules\In;

final class TestMarkEvaluatorTypeRules extends RulesContainer
{
    protected function rules(): array
    {
        return [
            'required',
            'string',
            new In(Test::EVALUATOR_TYPES),
        ];
    }
}
