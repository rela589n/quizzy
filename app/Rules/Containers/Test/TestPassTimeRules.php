<?php

declare(strict_types=1);


namespace App\Rules\Containers\Test;

use App\Rules\Containers\RulesContainer;

final class TestPassTimeRules extends RulesContainer
{
    protected function rules(): array
    {
        return [
            'required',
            'numeric',
            'min:1',
            'max:65000'
        ];
    }
}
