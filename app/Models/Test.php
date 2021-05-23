<?php

namespace App\Models;

use App\Lib\Traits\SlugScope;
use App\Models\Tests\TestEloquentBuilder;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Test
 *
 * @property int $id
 * @property int|null $created_by
 * @property string $name
 * @property string $uri_alias
 * @property int $time
 * @property int $test_subject_id
 * @property Carbon|null $deleted_at
 * @property string $mark_evaluator_type
 * @property string $type
 * @property string $display_strategy
 * @property ?int $attempts_per_user
 * @property ?int questions_count
 * @property string|null remainingAttemptsMessage
 * @property-read Collection|\App\Models\MarkPercent[] $marksPercents
 * @property-read int|null $marks_percents_count
 * @property-read Collection|\App\Models\Question[] $nativeQuestions
 * @property-read int|null $native_questions_count
 * @property-read \App\Models\TestSubject $subject
 * @property-read Collection|\App\Models\TestComposite[] $testComposites
 * @property-read int|null $test_composites_count
 * @property-read Collection|\App\Models\TestResult[] $testResults
 * @property-read int|null $test_results_count
 * @property-read int|null $user_results_count
 * @property-read Collection|Test[] $tests
 * @property-read int|null $tests_count
 * @method static \App\Models\Query\CustomEloquentBuilder|Test newModelQuery()
 * @method static \App\Models\Query\CustomEloquentBuilder|Test newQuery()
 * @method static \App\Models\Query\CustomEloquentBuilder|Test query()
 * @method static \App\Models\Query\CustomEloquentBuilder|Test whereCreatedBy($value)
 * @method static \App\Models\Query\CustomEloquentBuilder|Test whereDeletedAt($value)
 * @method static \App\Models\Query\CustomEloquentBuilder|Test whereId($value)
 * @method static \App\Models\Query\CustomEloquentBuilder|Test whereMarkEvaluatorType($value)
 * @method static \App\Models\Query\CustomEloquentBuilder|Test whereName($value)
 * @method static \App\Models\Query\CustomEloquentBuilder|Test whereSlug($slug)
 * @method static \App\Models\Query\CustomEloquentBuilder|Test whereTestSubjectId($value)
 * @method static \App\Models\Query\CustomEloquentBuilder|Test whereTime($value)
 * @method static \App\Models\Query\CustomEloquentBuilder|Test whereType($value)
 * @method static \App\Models\Query\CustomEloquentBuilder|Test whereUriAlias($value)
 * @method static \App\Models\Query\CustomEloquentBuilder|Test whereDisplayStrategy($value)
 * @method static \Illuminate\Database\Query\Builder|Test withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Test withoutTrashed()
 * @method static \Illuminate\Database\Query\Builder|Test onlyTrashed()
 * @mixin Eloquent
 * @property string $questions_order
 * @method static TestEloquentBuilder|Test availableForAdmin(\App\Models\Administrator $administrator)
 * @method static TestEloquentBuilder|Test whereAttemptsPerUser($value)
 * @method static TestEloquentBuilder|Test whereQuestionsOrder($value)
 * @method static TestEloquentBuilder|Test withUserResultsCount(\App\Models\User $user)
 * @property string $answer_options_order
 * @method static TestEloquentBuilder|Test whereAnswerOptionsOrder($value)
 * @property int $restrict_extraneous_activity
 * @method static TestEloquentBuilder|Test whereRestrictExtraneousActivity($value)
 * @property int $restrict_text_selection
 * @method static TestEloquentBuilder|Test whereRestrictTextSelection($value)
 */
class Test extends Model
{
    use SoftDeletes;
    use SlugScope;

    public const TYPE_STANDALONE = 'standalone';
    public const TYPE_COMPOSED = 'composed';

    public const TYPES = [
        self::TYPE_STANDALONE,
        self::TYPE_COMPOSED,
    ];

    public const DISPLAY_ALL = 'all';
    public const DISPLAY_ONE_BY_ONE = 'one by one';

    public const DISPLAY_STRATEGIES = [
        self::DISPLAY_ALL,
        self::DISPLAY_ONE_BY_ONE,
    ];

    public const EVALUATOR_TYPE_DEFAULT = 'default';
    public const EVALUATOR_TYPE_CUSTOM = 'custom';

    public const EVALUATOR_TYPES = [
        self::EVALUATOR_TYPE_DEFAULT,
        self::EVALUATOR_TYPE_CUSTOM,
    ];

    public const QUESTION_ORDER_RANDOM = 'random';
    public const QUESTION_ORDER_SERIATIM = 'seriatim';

    public const QUESTION_ORDERS = [
        self::QUESTION_ORDER_RANDOM,
        self::QUESTION_ORDER_SERIATIM,
    ];

    public const ANSWER_OPTION_ORDER_RANDOM = 'random';
    public const ANSWER_OPTION_ORDER_SERIATIM = 'seriatim';

    public const ANSWER_OPTION_ORDERS = [
        self::ANSWER_OPTION_ORDER_RANDOM,
        self::ANSWER_OPTION_ORDER_SERIATIM,
    ];

    public const EVALUATOR_LABELS = [
        'За замовчуванням',
        'Власна методика',
    ];

    public $timestamps = false;
    protected $fillable = ['name', 'uri_alias', 'time', 'mark_evaluator_type', 'test_subject_id'];

    protected $casts = [
        'restrict_extraneous_activity' => 'bool',
        'restrict_text_selection' => 'bool',
    ];

    public function subject(): BelongsTo
    {
        return $this->belongsTo(TestSubject::class, 'test_subject_id');
    }

    public function nativeQuestions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function tests(): BelongsToMany
    {
        return $this->belongsToMany(
            self::class,
            'test_composite',
            'id_test',
            'id_include_test'
        )->using(TestComposite::class)
            ->withPivot(['questions_quantity']);
    }

    public function testComposites(): HasMany
    {
        return $this->hasMany(TestComposite::class, 'id_test');
    }

    /** @return HasMany|TestResult */
    public function testResults(): HasMany
    {
        return $this->hasMany(TestResult::class);
    }

    public function marksPercents(): HasMany
    {
        return $this->hasMany(MarkPercent::class);
    }

    public function isComposite(): bool
    {
        return self::TYPE_COMPOSED === $this->type;
    }

    public function shouldDisplayAllQuestions(): bool
    {
        return self::DISPLAY_ALL === $this->display_strategy;
    }

    public function shouldDisplayOneByOneQuestions(): bool
    {
        return self::DISPLAY_ONE_BY_ONE === $this->display_strategy;
    }

    public function isAvailableToAdmin(Administrator $model): bool
    {
        return $model->id === $this->created_by;
    }

    public function newEloquentBuilder($query): TestEloquentBuilder
    {
        return new TestEloquentBuilder($query);
    }
}
