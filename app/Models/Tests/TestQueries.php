<?php

declare(strict_types=1);

namespace App\Models\Tests;

use App\Models\TestSubject;
use Illuminate\Database\Eloquent\Collection;

interface TestQueries
{
    /**
     * @return Collection|TestSubject
     */
    public function subjectsWithTestsToAttachQuestions(): Collection;
}
