<?php


namespace App\Models\TestResults;


use App\Lib\Filters\Eloquent\ResultFilter;
use App\Lib\Traits\FilteredScope;
use App\Models\Test;
use App\Models\TestResult;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/** @mixin TestResult */
class TestResultQueryBuilder extends Builder
{
    use FilteredScope {
        scopeFiltered as private;
    }

    public function ofTest($test): self
    {
        $testId = is_numeric($test) ? $test : $test->id;

        return $this->whereHas(
            'test',
            static function (Builder $query) use ($testId) {
                /**
                 * @var Builder|Test $query
                 */

                $query->withTrashed();
                $query->where('id', $testId);
            }
        );
    }

    public function recent($count): self
    {
        return $this->latest()->limit($count);
    }

    /**
     * @param  ResultFilter  $filters
     * @param  callable|null  $callback
     *
     * @return Collection|TestResult[]
     */
    public function filtered(ResultFilter $filters, callable $callback = null): Collection
    {
        return $this->scopeFiltered($this, $filters, $callback);
    }

    public function withPercentage()
    {
        $this->with(
            [
                'test',
                'askedQuestions.question',
                'askedQuestions.answers.answerOption',
                'user.studentGroup',
            ]
        );

//        $result =
// result = sum(questions_score)
// questions_score = [1, 0, 1, 0, 0]
// score_value = option_ans == option_right

        $sql = <<< SQL
select test_results.*,
       (
           select sum(question_score)
           from (
               select 1 * (answers_right / all_answers) as question_score
               from (
                    select count(*) as all_answers from answer_options where questions.id = answer_options.question_id
               ), (
                  select count(*) as answers_right from answers where questions.id = answers.question_id
                                                                  and answer_options.is_right = answers.id_selected
               )
               where asked_questions.id = questions.id
           )

        ) as total_score
from test_results
where id in(1, 2, 3);
SQL;
        $sql = <<< SQL

select test_results.*,
        (
            select sum(question_score) from (
                select asked_questions.*,
                       asked_questions.id as question_score
                where asked_questions.test_result_id = test_results.id
            )
        ) as total_score
from test_results
where id in(1, 2, 3);

select test_results.*,
       (
           select sum(question_score)
           from (
                    select asked_questions.*,
                           asked_questions.id as question_score
                    from asked_questions
                    where asked_questions.test_result_id = test_results.id
                ) as question_scores
       ) as total_score
from test_results
where test_results.id in (1, 2, 3);

select answer_options.*,
       answers.*
from answer_options
inner join answers
on answer_options.id=answers.answer_option_id


SQL;

//        $this->withSum()
    }
}
