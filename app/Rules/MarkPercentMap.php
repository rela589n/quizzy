<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MarkPercentMap implements Rule
{
    /**
     * @var string
     */
    protected $markAlias;

    /**
     * @var string
     */
    protected $percentAlias;

    /**
     * MarkPercentMap constructor.
     * @param string $markAlias
     * @param string $percentAlias
     */
    public function __construct(string $markAlias = 'mark',
                                string $percentAlias = 'percent')
    {
        $this->markAlias = $markAlias;
        $this->percentAlias = $percentAlias;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param array $markPercentMap
     * @return bool
     */
    public function passes($attribute, $markPercentMap)
    {
        usort($markPercentMap, function ($a, $b) {
            return (int)($a[$this->markAlias]) <=> (int)($b[$this->markAlias]);
        });

        for ($i = 1; $i < count($markPercentMap); ++$i) {
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
    public function message()
    {
        return trans('validation.custom.mark_percent_map');
    }
}
