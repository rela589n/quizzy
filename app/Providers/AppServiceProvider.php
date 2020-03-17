<?php

namespace App\Providers;

use App\Lib\Statements\FilePathGenerators\GroupResultFileNameGenerator;
use App\Lib\Statements\FilePathGenerators\ResultFileNameGenerator;
use App\Lib\Statements\FilePathGenerators\StudentResultFileNameGenerator;
use App\Lib\Statements\GroupStatementsGenerator;
use App\Lib\Statements\StatementsGenerator;
use App\Lib\Statements\StudentStatementsGenerator;
use App\Lib\TestResults\MarkEvaluatorInterface;
use App\Lib\TestResults\ScoreEvaluatorInterface;
use App\Lib\TestResults\StrictMarkEvaluator;
use App\Lib\TestResults\StrictScoreEvaluator;
use App\Lib\TestResultsEvaluator;
use App\Lib\Words\Decliners\CyrillicWordDecliner;
use App\Lib\Words\Decliners\WordDeclinerInterface;
use App\Lib\Words\Repositories\UkrainianWordsRepository;
use App\Lib\Words\Repositories\WordsRepository;
use App\Lib\Words\WordsManager;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->when(TestResultsEvaluator::class)
            ->needs(ScoreEvaluatorInterface::class)
            ->give(StrictScoreEvaluator::class);

        $this->app->when(TestResultsEvaluator::class)
            ->needs(MarkEvaluatorInterface::class)
            ->give(StrictMarkEvaluator::class);

        $this->app->when(WordsManager::class)
            ->needs(WordDeclinerInterface::class)
            ->give(CyrillicWordDecliner::class);

        $this->app->when(WordsManager::class)
            ->needs(WordsRepository::class)
            ->give(UkrainianWordsRepository::class);

        $this->app->when(StudentStatementsGenerator::class)
            ->needs(ResultFileNameGenerator::class)
            ->give(StudentResultFileNameGenerator::class);

        $this->app->when(GroupStatementsGenerator::class)
            ->needs(ResultFileNameGenerator::class)
            ->give(GroupResultFileNameGenerator::class);
    }
}
