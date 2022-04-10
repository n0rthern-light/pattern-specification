<?php

namespace Nlf\Component\Pattern\Specification;

interface SpecificationInterface
{
    public function isSatisfiedBy(object $object): bool;
}