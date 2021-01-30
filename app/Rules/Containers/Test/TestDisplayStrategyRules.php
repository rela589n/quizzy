<?php

declare(strict_types=1);


namespace App\Rules\Containers\Test;

use App\Models\Test;
use App\Rules\Containers\RulesContainer;
use Illuminate\Validation\Rule;

final class TestDisplayStrategyRules extends RulesContainer
{
    protected function rules(): array
    {
        return [
            Rule::in(Test::DISPLAY_STRATEGIES),
        ];
    }
}
