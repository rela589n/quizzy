<?php

namespace App\Nova\Actions;

use App\Models\Administrator;
use App\Models\Test;
use App\Models\Tests\TestQueries;
use App\Models\TestSubject;
use Epartment\NovaDependencyContainer\NovaDependencyContainer;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;

class AttachTestsQuestionsToTest extends Action
{
    use InteractsWithQueue, Queueable;

    public $name = 'Прикріпити питання до іншого';

    private TestQueries $queries;

    public function __construct()
    {
        $this->queries = resolve(TestQueries::class);
    }

    /**
     * Perform the action on the given models.
     *
     * @param  ActionFields  $fields
     * @param  Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $subjectId = $fields->get('test_subject');
        $testId = $fields->get('test');

        /** @var Test $test */
        $test = Test::query()->findOrFail($testId);
        $test->tests()->syncWithoutDetaching($models->pluck('id'));
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields(): array
    {
        /** @var Administrator $administrator */
        $administrator = Auth::user();

        $subjects = $this->queries->subjectsWithTestsToAttachQuestions($administrator);

        return [
            $this->createTestSubjectField($subjects),

            ...$this->createTestDependentFields($subjects),
        ];
    }

    private function createTestSubjectField(EloquentCollection $subjects): Select
    {
        return Select::make('Предмет', 'test_subject')
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
        $testsBySubjects = $subjects->mapWithKeys(
            fn(TestSubject $subject) => [
                $subject->id => $subject->tests->filter(
                    static fn(Test $test) => $test->isComposite()
                )
            ]
        );

        return $testsBySubjects->map(
            fn(Collection $tests, int $subjectId) => NovaDependencyContainer::make(
                [
                    Select::make('Тест', 'test')
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
