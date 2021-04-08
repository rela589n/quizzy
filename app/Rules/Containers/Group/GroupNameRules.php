<?php

declare(strict_types=1);


namespace App\Rules\Containers\Group;

use App\Rules\Containers\RulesContainer;
use Illuminate\Validation\Rules\Unique;

final class GroupNameRules extends RulesContainer
{
    protected function rules(): array
    {
        return [
            'required',
            'min:4',
            'max:32',
        ];
    }

    public static function forCreate(): self
    {
        $rules = new self();
        $rules->merge(['uniqueness' => new Unique('student_groups')]);

        return $rules;
    }

    public static function forUpdate(): self
    {
        $rules = new self();
        $rules->merge(['unique:student_groups,name,{{resourceId}}']);

        return $rules;
    }
}
