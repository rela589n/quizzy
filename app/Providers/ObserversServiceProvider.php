<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\AnswerOption;
use App\Models\AskedQuestion;
use App\Models\Question;
use App\Observers\AnswerOptionObserver;
use App\Observers\AskedQuestionObserver;
use App\Observers\QuestionObserver;
use Illuminate\Support\ServiceProvider;

final class ObserversServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        Question::observe(QuestionObserver::class);
        AnswerOption::observe(AnswerOptionObserver::class);
        AskedQuestion::observe(AskedQuestionObserver::class);
    }
}
