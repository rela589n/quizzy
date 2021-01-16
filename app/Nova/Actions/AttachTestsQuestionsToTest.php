<?php

namespace App\Nova\Actions;

use App\Models\Test;
use App\Models\Tests\TestQueries;
use App\Models\TestSubject;
use Epartment\NovaDependencyContainer\NovaDependencyContainer;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;

class AttachTestsQuestionsToTest extends Action
{
    use InteractsWithQueue, Queueable;

    private TestQueries $queries;

    public function __construct()
    {
        $this->queries = resolve(TestQueries::class);
    }

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        // todo
        dump($fields);
        dd($models);
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        // todo maybe filter by departments of teacher and available tests
        $subjects = $this->queries->subjectsWithTestsToAttachQuestions();

        return [
            $this->createTestSubjectField($subjects),

            ...$this->createTestDependentFields($subjects),
        ];
    }

    private function createTestSubjectField(EloquentCollection $subjects): Select
    {
        return Select::make('Test Subject', 'test_subject')
            ->options(
                $subjects->mapWithKeys(
                    fn(TestSubject $subject) => [$subject->id => "({$subject->id}) {$subject->name}"]
                )
            )
            ->displayUsingLabels()
            ->rules('required');
    }

    private function createTestDependentFields(EloquentCollection $subjects)
    {
        $testsBySubjects = $subjects->mapWithKeys(fn(TestSubject $subject) => [$subject->id => $subject->tests]);

        return $testsBySubjects->map(
            fn(Collection $tests, int $subjectId) => NovaDependencyContainer::make(
                [
                    Select::make('Test', 'test')
                        ->options(
                            $tests->mapWithKeys(
                                fn(Test $test) => [$test->id => "({$test->id}) {$test->name}"]
                            )
                        )
                        ->displayUsingLabels()
                        ->rules('required'),
                ]
            )->dependsOn('test_subject', $subjectId)
        );
    }
}
