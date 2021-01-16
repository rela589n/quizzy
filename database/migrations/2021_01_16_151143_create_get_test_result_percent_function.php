<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;

final class CreateGetTestResultPercentFunction extends Migration
{
    public function up()
    {
        \Illuminate\Support\Facades\DB::unprepared(
            <<<SQL
create function test_result_in_percents(test_result_id bigint unsigned)
    returns float
begin
    return (
        select sum(tmp.question_right) * 100 / count(*)
        from (select sum(answers.is_chosen = answer_options.is_right) = count(*) as question_right
                   , asked_questions.test_result_id                              as test_result_id
              from answers
                       inner join answer_options on answer_options.id = answers.answer_option_id
                       inner join asked_questions on asked_questions.id = answers.asked_question_id
              where asked_questions.test_result_id = test_result_id
              group by answers.asked_question_id
             ) as tmp
        group by test_result_id
    );
end;
SQL
        );
    }

    public function down()
    {
        \Illuminate\Support\Facades\DB::unprepared('drop function test_result_in_percents');
    }
}
