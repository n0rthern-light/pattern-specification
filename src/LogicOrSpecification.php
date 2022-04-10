<?php

namespace Nlf\Component\Pattern\Specification;

class LogicOrSpecification implements SpecificationInterface
{
    private SpecificationInterface $a;
    private SpecificationInterface $b;

    public function __construct(SpecificationInterface $a, SpecificationInterface $b)
    {
        $this->a = $a;
        $this->b = $b;
    }

    public function isSatisfiedBy(object $object): bool
    {
        return $this->a->isSatisfiedBy($object)
            || $this->b->isSatisfiedBy($object);
    }
}