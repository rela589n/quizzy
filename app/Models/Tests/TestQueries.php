<?php

declare(strict_types=1);

namespace App\Models\Tests;

use App\Models\Administrator;
use App\Models\TestSubject;
use Illuminate\Database\Eloquent\Collection;

interface TestQueries
{
    /**
     * @param  Administrator  $administrator
     * @return Collection|TestSubject
     */
    public function subjectsWithTestsToAttachQuestions(Administrator $administrator): Collection;
}
