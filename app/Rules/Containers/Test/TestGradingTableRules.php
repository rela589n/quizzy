<?php

declare(strict_types=1);


namespace App\Rules\Containers\Test;

use App\Models\Test;
use App\Rules\Containers\RulesContainer;
use App\Rules\MarkPercentMap;

final class TestGradingTableRules extends RulesContainer
{
    protected function rules(): array
    {
        return [
            'required_if:mark_evaluator_type,'.Test::EVALUATOR_TYPE_CUSTOM,
            'array',
            'mapRule' => new MarkPercentMap()
        ];
    }

    public function usingJson(): self
    {
        $this->without('array');
        $this->tweak('mapRule', fn() => new MarkPercentMap('mark', 'percent', MarkPercentMap::TYPE_JSON));

        return $this;
    }
}
