<?php

declare(strict_types=1);

namespace App\Models\Questions;

final class QuestionType
{
    private string $type;

    public function __construct(string $type) { $this->type = $type; }

    public static function options(): array
    {
        return [
            (string)self::RADIO(),
            (string)self::CHECKBOXES(),
        ];
    }

    public static function RADIO(): self
    {
        return new self('radio');
    }

    public static function CHECKBOXES(): self
    {
        return new self('checkboxes');
    }

    public function equalsTo($other): bool
    {
        if (null === $other) {
            return false;
        }

        if ($other instanceof self) {
            return $other->type === $this->type;
        }

        return $this->equalsTo(new self($other));
    }

    public function __toString(): string
    {
        return $this->type;
    }
}
