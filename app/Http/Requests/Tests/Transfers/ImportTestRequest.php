<?php

namespace App\Http\Requests\Tests\Transfers;

use App\Http\Requests\RequestUrlManager;
use App\Models\Administrator;
use App\Rules\Containers\Test\TestImportFileRules;
use Illuminate\Foundation\Http\FormRequest;

final class ImportTestRequest extends FormRequest
{
    public function authorize(Administrator $user, RequestUrlManager $urlManager): bool
    {
        return $user->can('update', $urlManager->getCurrentTest());
    }

    public function rules(): array
    {
        return [
            'selected-file' => new TestImportFileRules(),
        ];
    }
}
