<?php

namespace Nlf\Component\Pattern\Specification;

class LogicNotSpecification implements SpecificationInterface
{
    private SpecificationInterface $specification;

    public function __construct(SpecificationInterface $specification)
    {
        $this->specification = $specification;
    }

    public function isSatisfiedBy(object $object): bool
    {
        return !$this->specification->isSatisfiedBy($object);
    }
}