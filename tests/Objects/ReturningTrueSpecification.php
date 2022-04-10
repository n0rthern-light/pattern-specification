<?php

namespace Nlf\Component\Pattern\Specification\Tests\Objects;

use Nlf\Component\Pattern\Specification\SpecificationInterface;

class ReturningTrueSpecification implements SpecificationInterface
{
    public function isSatisfiedBy(object $object): bool
    {
        return true;
    }
}