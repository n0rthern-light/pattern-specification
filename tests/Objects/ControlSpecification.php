<?php

namespace Nlf\Component\Pattern\Specification\Tests\Objects;

use Nlf\Component\Pattern\Specification\SpecificationInterface;

class ControlSpecification implements SpecificationInterface
{
    /** @param ControlObject $object */
    public function isSatisfiedBy(object $object): bool
    {
        return $object->isTrue();
    }
}