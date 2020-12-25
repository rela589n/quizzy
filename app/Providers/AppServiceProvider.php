<?php

namespace App\Providers;

use App\Lib\Statements\FilePathGenerators\ExportResultFileNameGenerator;
use App\Lib\Statements\FilePathGenerators\GroupResultFileNameGenerator;
use App\Lib\Statements\FilePathGenerators\ResultFileNameGenerator;
use App\Lib\Statements\FilePathGenerators\StudentResultFileNameGenerator;
use App\Lib\Statements\GroupStatementsGenerator;
use App\Lib\Statements\StudentStatementsGenerator;
use App\Lib\Statements\TestsExportManager;
use App\Lib\TestResults\CustomMarkEvaluator;
use App\Lib\TestResults\ScoreEvaluatorInterface;
use App\Lib\TestResults\StrictMarkEvaluator;
use App\Lib\TestResults\StrictScoreEvaluator;
use App\Lib\TestResultsEvaluator;
use App\Lib\Words\Decliners\CyrillicWordDecliner;
use App\Lib\Words\Decliners\WordDeclinerInterface;
use App\Lib\Words\Repositories\UkrainianWordsRepository;
use App\Lib\Words\Repositories\WordsRepository;
use App\Lib\Words\WordsManager;
use App\Models\Administrator;
use App\Models\Query\CustomBuilder;
use App\Models\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerBindings();

        $this->shareViews();
    }

    private function registerBindings(): void
    {
        $this->app->when(TestResultsEvaluator::class)
            ->needs(ScoreEvaluatorInterface::class)
            ->give(StrictScoreEvaluator::class);

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

        $this->app->when(TestsExportManager::class)
            ->needs(ResultFileNameGenerator::class)
            ->give(ExportResultFileNameGenerator::class);

        $this->bindAuthUsers();

        $this->registerSingletons();
    }

    private function shareViews(): void
    {
        View::composer(
            '*',
            static function ($view) {
                $view->with('authUser', Auth::user());
            }
        );
    }

    private function bindAuthUsers(): void
    {
        $this->app->bind(
            Administrator::class,
            static function () {
                return Auth::guard('admin')->user();
            }
        );

        $this->app->bind(
            User::class,
            static function () {
                return Auth::guard('client')->user();
            }
        );
    }

    private function registerSingletons(): void
    {
        $this->app->singleton(StrictMarkEvaluator::class);
        $this->app->singleton(CustomMarkEvaluator::class);
    }
}
