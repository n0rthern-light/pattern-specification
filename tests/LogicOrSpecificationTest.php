<?php

namespace Nlf\Component\Pattern\Specification\Tests;

use Generator;
use Nlf\Component\Pattern\Specification\LogicNotSpecification;
use Nlf\Component\Pattern\Specification\LogicOrSpecification;
use Nlf\Component\Pattern\Specification\SpecificationInterface;
use Nlf\Component\Pattern\Specification\Tests\Objects\ControlObject;
use Nlf\Component\Pattern\Specification\Tests\Objects\ControlSpecification;
use Nlf\Component\Pattern\Specification\Tests\Objects\ReturningFalseSpecification;
use Nlf\Component\Pattern\Specification\Tests\Objects\ReturningTrueSpecification;
use PHPUnit\Framework\TestCase;
use stdClass;

class LogicOrSpecificationTest extends TestCase
{
    /** @dataProvider dataProviderOperandTest */
    public function testOperand(SpecificationInterface $a, SpecificationInterface $b, bool $expectedIsSatisfied): void
    {
        $or = new LogicOrSpecification($a, $b);

        $this->assertEquals($expectedIsSatisfied, $or->isSatisfiedBy(new stdClass));
    }

    public function dataProviderOperandTest(): Generator
    {
        yield [
            new ReturningTrueSpecification(),
            new ReturningFalseSpecification(),
            true,
        ];

        yield [
            new ReturningFalseSpecification(),
            new ReturningTrueSpecification(),
            true,
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
        $or = new LogicOrSpecification($a, $b);

        $control = new ControlObject($initialBit);

        $this->assertEquals($expectedInitialBit, $or->isSatisfiedBy($control));

        $control->setBit($afterBit);

        $this->assertEquals($expectedAfterBit, $or->isSatisfiedBy($control));
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
            true,
            true,
        ];

        yield [
            new ControlSpecification(),
            new LogicNotSpecification(new ControlSpecification()),
            false,
            true,
            true,
            true,
        ];

        yield [
            new LogicNotSpecification(new ControlSpecification()),
            new ControlSpecification(),
            true,
            false,
            true,
            true,
        ];

        yield [
            new LogicNotSpecification(new ControlSpecification()),
            new ControlSpecification(),
            false,
            true,
            true,
            true,
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