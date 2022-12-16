<?php

namespace Shared\Domain\ValueObject;

class IntValueObject
{
    protected int $value;

    public function __construct(int|string $value)
    {
        $this->value = (int) $value;
    }

    public function value(): int
    {
        return $this->value;
    }

}