<?php

declare(strict_types=1);


namespace App\Rules\Containers\Test;

use App\Rules\Containers\RulesContainer;

final class TestImportFileRules extends RulesContainer
{
    protected function rules(): array
    {
        return [
            'required',
            'file',
            'max:2048',
            'mimes:doc,docx,txt,bin,pdf,zip',
        ];
    }
}
