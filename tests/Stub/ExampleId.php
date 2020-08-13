<?php

namespace Tests\Stub;

class ExampleId
{
    private int $value;

    public static function fromPrimitive(int $value): self
    {
        return new self($value);
    }

    public function equalsTo(self $other): bool
    {
        return $this->value === $other->value;
    }
}