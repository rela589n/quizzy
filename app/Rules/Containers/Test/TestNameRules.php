<?php

declare(strict_types=1);


namespace App\Rules\Containers\Test;

use App\Rules\Containers\RulesContainer;

final class TestNameRules extends RulesContainer
{
    protected function rules(): array
    {
        return [
            'required',
            'min:3',
            'max:128',
        ];
    }
}
