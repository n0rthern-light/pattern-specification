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

class LogicNotSpecificationTest extends TestCase
{
    /** @dataProvider dataProviderOperandTest */
    public function testOperand(SpecificationInterface $specification, bool $expectedIsSatisfied): void
    {
        $this->assertEquals($expectedIsSatisfied, $specification->isSatisfiedBy(new stdClass));
    }

    public function dataProviderOperandTest(): Generator
    {
        yield [
            new LogicNotSpecification(new ReturningTrueSpecification()),
            false,
        ];

        yield [
            new LogicNotSpecification(
                new LogicNotSpecification(
                    new ReturningTrueSpecification()
                )
            ),
            true,
        ];

        yield [
            new LogicNotSpecification(new ReturningFalseSpecification()),
            true,
        ];

        yield [
            new LogicNotSpecification(
                new LogicNotSpecification(
                    new ReturningFalseSpecification()
                )
            ),
            false,
        ];
    }
}