<?php

namespace App\Providers;

use App\Http\Requests\RequestUrlManager;
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
use App\Lib\Tests\Pass\PassTestService;
use App\Lib\Words\Decliners\CyrillicWordDecliner;
use App\Lib\Words\Decliners\WordDeclinerInterface;
use App\Lib\Words\Repositories\UkrainianWordsRepository;
use App\Lib\Words\Repositories\WordsRepository;
use App\Lib\Words\WordsManager;
use App\Models\Administrator;
use App\Models\Tests\TestQueries;
use App\Models\Tests\TestQueriesImpl;
use App\Models\Tests\TestQueriesWeakCacheDecorator;
use App\Models\User;
use App\Repositories\StudentGroupsRepository;
use Illuminate\Pagination\Paginator;
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
        $this->registerBindings();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

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

        $this->app->bind(TestQueries::class, TestQueriesImpl::class);
        $this->app->extend(
            TestQueries::class,
            function (TestQueries $service) {
                return resolve(
                    TestQueriesWeakCacheDecorator::class,
                    [
                        'queries' => $service,
                    ]
                );
            }
        );

        $this->app->singleton(StudentGroupsRepository::class);

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
    }
}
