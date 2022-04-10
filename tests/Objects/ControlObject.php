<?php

namespace Nlf\Component\Pattern\Specification\Tests\Objects;

class ControlObject
{
    private bool $bit;

    public function __construct(bool $bit)
    {
        $this->bit = $bit;
    }

    public function setBit(bool $bit): static
    {
        $this->bit = $bit;

        return $this;
    }

    public function isTrue(): bool
    {
        return $this->bit;
    }
}