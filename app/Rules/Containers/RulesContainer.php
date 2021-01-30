<?php

declare(strict_types=1);


namespace App\Rules\Containers;

abstract class RulesContainer
{
    /** @var array  */
    protected $rules;

    public function __construct()
    {
        $this->rules = $this->rules();
    }

    protected function merge(array $otherRules): self
    {
        $this->rules = array_merge($this->rules, $otherRules);

        return $this;
    }

    protected function tweak(string $key, \Closure $replacer): self
    {
        $this->rules[$key] = $replacer($this->rules[$key]);

        return $this;
    }

    protected function without(string $rule): self
    {
        unset($this->rules[array_search($rule, $this->rules, true)]);

        return $this;
    }

    public function build(): array
    {
        return $this->rules;
    }

    abstract protected function rules(): array;
}
