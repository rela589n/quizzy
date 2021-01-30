<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Webmozart\Assert\Assert;

class MarkPercentMap implements Rule
{
    public const TYPE_ARRAY = 'array';
    public const TYPE_JSON = 'json';

    protected string $markAlias;
    protected string $percentAlias;
    protected string $type;
    protected string $field = 'correlation_table';

    public function __construct(
        string $markAlias = 'mark',
        string $percentAlias = 'percent',
        string $type = self::TYPE_ARRAY
    ) {
        $this->markAlias = $markAlias;
        $this->percentAlias = $percentAlias;
        $this->type = $type;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  array|string  $markPercentMap
     * @return bool
     */
    public function passes($attribute, $markPercentMap): bool
    {
        if (self::TYPE_ARRAY === $this->type) {
            Assert::isArray($markPercentMap);
        }

        if (self::TYPE_JSON === $this->type) {
            Assert::string($markPercentMap);

            $markPercentMap = json_decode($markPercentMap, true, 512, JSON_THROW_ON_ERROR);
        }

        Validator::validate(
            [
                $this->field => $markPercentMap
            ],
            [
                $this->field => [
                    'array',
                    'min:3',
                ],
            ]
        );

        usort(
            $markPercentMap,
            function ($a, $b) {
                return (int)($a[$this->markAlias]) <=> (int)($b[$this->markAlias]);
            }
        );

        for ($i = 1, $iMax = count($markPercentMap); $i < $iMax; ++$i) {
            if ((float)$markPercentMap[$i - 1][$this->percentAlias] >= (float)$markPercentMap[$i][$this->percentAlias]) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return trans('validation.custom.mark_percent_map');
    }
}
