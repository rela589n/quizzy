<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\AskedQuestion;

final class AskedQuestionObserver
{
    /**
     * Handle the asked question "deleted" event.
     *
     * @param  AskedQuestion  $askedQuestion
     */
    public function deleted(AskedQuestion $askedQuestion)
    {
        $askedQuestion->answers()->delete();
    }
}
