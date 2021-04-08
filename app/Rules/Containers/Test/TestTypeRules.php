<?php

declare(strict_types=1);


namespace App\Rules\Containers\Test;

use App\Rules\Containers\RulesContainer;
use Illuminate\Validation\Rule;

final class TestTypeRules extends RulesContainer
{
    protected function rules(): array
    {
        return [
            Rule::in(\App\Models\Test::TYPES),
        ];
    }
}
