<?php

declare(strict_types=1);


namespace App\Rules\Containers\Group;

use App\Rules\Containers\RulesContainer;

final class GroupYearRules extends RulesContainer
{
    protected function rules(): array
    {
        return [
            'required',
            'numeric',
            'max:'.date('Y'),
        ];
    }

    public static function forCreate(): self
    {
        $rules = new self();
        $rules->merge(['min:'.(date('Y') - 5)]);
        return $rules;
    }

    public static function forUpdate(): self
    {
        $rules = new self();
        $rules->merge(['min:'.(date('Y') - 10)]);
        return $rules;
    }
}
