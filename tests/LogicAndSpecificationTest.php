<?php

namespace Nlf\Component\Pattern\Specification\Tests;

use Generator;
use Nlf\Component\Pattern\Specification\LogicAndSpecification;
use Nlf\Component\Pattern\Specification\LogicNotSpecification;
use Nlf\Component\Pattern\Specification\SpecificationInterface;
use Nlf\Component\Pattern\Specification\Tests\Objects\ControlObject;
use Nlf\Component\Pattern\Specification\Tests\Objects\ControlSpecification;
use Nlf\Component\Pattern\Specification\Tests\Objects\ReturningFalseSpecification;
use Nlf\Component\Pattern\Specification\Tests\Objects\ReturningTrueSpecification;
use PHPUnit\Framework\TestCase;
use stdClass;

class LogicAndSpecificationTest extends TestCase
{
    /** @dataProvider dataProviderOperandTest */
    public function testOperand(SpecificationInterface $a, SpecificationInterface $b, bool $expectedIsSatisfied): void
    {
        $and = new LogicAndSpecification($a, $b);

        $this->assertEquals($expectedIsSatisfied, $and->isSatisfiedBy(new stdClass));
    }

    public function dataProviderOperandTest(): Generator
    {
        yield [
            new ReturningTrueSpecification(),
            new ReturningFalseSpecification(),
            false,
        ];

        yield [
            new ReturningFalseSpecification(),
            new ReturningTrueSpecification(),
            false,
        ];

        yield [
            new ReturningFalseSpecification(),
            new ReturningFalseSpecification(),
            false,
        ];

        yield [
            new ReturningTrueSpecification(),
            new ReturningTrueSpecification(),
            true,
        ];
    }

    /** @dataProvider dataProviderOperandWhenTestedObjectChangeTest */
    public function testOperandWhenTestedObjectChange(
        SpecificationInterface $a,
        SpecificationInterface $b,
        bool $initialBit,
        bool $afterBit,
        bool $expectedInitialBit,
        bool $expectedAfterBit
    ): void {
        $and = new LogicAndSpecification($a, $b);

        $control = new ControlObject($initialBit);

        $this->assertEquals($expectedInitialBit, $and->isSatisfiedBy($control));

        $control->setBit($afterBit);

        $this->assertEquals($expectedAfterBit, $and->isSatisfiedBy($control));
    }

    public function dataProviderOperandWhenTestedObjectChangeTest(): Generator
    {
        yield [
            new ControlSpecification(),
            new ControlSpecification(),
            true,
            false,
            true,
            false,
        ];

        yield [
            new ControlSpecification(),
            new ControlSpecification(),
            false,
            true,
            false,
            true,
        ];

        yield [
            new ControlSpecification(),
            new LogicNotSpecification(new ControlSpecification()),
            true,
            false,
            false,
            false,
        ];

        yield [
            new ControlSpecification(),
            new LogicNotSpecification(new ControlSpecification()),
            false,
            true,
            false,
            false,
        ];

        yield [
            new LogicNotSpecification(new ControlSpecification()),
            new ControlSpecification(),
            true,
            false,
            false,
            false,
        ];

        yield [
            new LogicNotSpecification(new ControlSpecification()),
            new ControlSpecification(),
            false,
            true,
            false,
            false,
        ];

        yield [
            new LogicNotSpecification(new ControlSpecification()),
            new LogicNotSpecification(new ControlSpecification()),
            true,
            false,
            false,
            true,
        ];

        yield [
            new LogicNotSpecification(new ControlSpecification()),
            new LogicNotSpecification(new ControlSpecification()),
            false,
            true,
            true,
            false,
        ];
    }
}