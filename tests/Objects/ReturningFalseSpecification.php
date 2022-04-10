<?php

namespace Nlf\Component\Pattern\Specification\Tests\Objects;

use Nlf\Component\Pattern\Specification\SpecificationInterface;

class ReturningFalseSpecification implements SpecificationInterface
{
    public function isSatisfiedBy(object $object): bool
    {
        return false;
    }
}