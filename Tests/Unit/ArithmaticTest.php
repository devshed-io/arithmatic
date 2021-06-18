<?php

namespace Devshed\Arithmatic\Tests\Unit;

use Devshed\Arithmatic\Arithmatic;
use PHPUnit\Framework\TestCase;

class ArithmaticTest extends TestCase
{
    public function testItStartsWithANumber()
    {
        $this->assertEquals(5, Arithmatic::start(5)->output());
        $this->assertEquals(10, Arithmatic::make(10)->output());
    }

    public function testItProvidesAnOutput()
    {
        $number = new Arithmatic(5);

        $this->assertTrue(method_exists($number, 'output'));
    }

    public function testItPerformsAddition()
    {
        $number = Arithmatic
            ::start(5)
            ->add(5);

        $this->assertEquals(10, $number->output());
    }

    public function testItPerformsSubtraction()
    {
        $number = Arithmatic
            ::start(5)
            ->subtract(2);

        $this->assertEquals(3, $number->output());
    }

    public function testItPerformsDivision()
    {
        $number = Arithmatic::start(5)->divide(2);

        $this->assertEquals(2.5, $number->output());
    }

    public function testItPerformsPercentageChange()
    {
        $number = Arithmatic::start(100)->percentageChange(80);

        $this->assertEquals(25.0, $number->output());

        $number = Arithmatic::start(100)->percentageChange(125);

        $this->assertEquals(-20.0, $number->output());

        $number = Arithmatic::start(15)->percentageChange(-5);

        $this->assertEquals(400, $number->output());
    }

    public function testItPerformsMultiplication()
    {
        $this->assertEquals(
            12,
            Arithmatic::make(4)->multiply(3)->output()
        );
    }

    public function testItCanCalculateMean()
    {
        $this->assertEquals(Arithmatic::make([1, 3, 8, 5, 3, 1, 2])->mean()->output(), 3.285714285714286);
        $this->assertEquals(Arithmatic::make(15)->mean()->output(), 15);
    }

    public function testItPerformsPercentageOfTotal()
    {
        $this->assertEquals(
            Arithmatic::make(50)->percentageOf(200)->output(),
            25,
        );
    }

    public function testItRoundsAValue()
    {
        $number = Arithmatic::make(9.6)->round();

        $this->assertEquals(10.0, $number->output());
    }

    public function testItCanCoerceArithmaticInstancesToBasicTypes()
    {
        $ten = Arithmatic::make(10);

        $this->assertEquals(20, Arithmatic::make(10)->add($ten)->output());
        $this->assertEquals(5, Arithmatic::make($ten)->percentageOf(Arithmatic::make(200))->output());
    }

    public function testItCanRunStringReferencedMethods()
    {
        $number = Arithmatic
            ::make(9.6)
            ->run(['round']);

        $this->assertEquals(10, $number->output());
    }

    public function testItCanRunStringReferencedMethodsWithParameters()
    {
        $number = Arithmatic
            ::make(10)
            ->run(['add' => 5, 'divide' => 2]);

        $this->assertEquals(7.5, $number->output());
    }

    public function testItCanRunAStringReferenceMethodConditionally()
    {
        $number = Arithmatic
            ::make(10)
            ->when(true, ['add' => 5, 'divide' => 2]);

        $this->assertEquals(7.5, $number->output());
    }

    public function testItCanRunAClosureConditionally()
    {
        $number = Arithmatic
            ::make(10)
            ->when(true, function (Arithmatic $instance) {
                return $instance->add(5);
            });

        $this->assertEquals(15, $number->output());

        $number = Arithmatic
            ::make(10)
            ->when(false, function (Arithmatic $instance) {
                return $instance->add(5);
            });

        $this->assertEquals(10, $number->output());
    }

    public function testItCanRunAConditionalMethodWithAFallback()
    {
        $number = Arithmatic
            ::make(10)
            ->when(true, ['add' => 5], ['subtract' => 2]);

        $this->assertEquals(15, $number->output());

        $number = Arithmatic
            ::make(10)
            ->when(false, ['add' => 5], ['subtract' => 2]);

        $this->assertEquals(8, $number->output());

        $number = Arithmatic
            ::make(10)
            ->when(
                false,
                function (Arithmatic $arithmatic) {
                    return $arithmatic->add(7);
                },
                function (Arithmatic $arithmatic) {
                    return $arithmatic->subtract(7);
                }
            );

        $this->assertEquals(3, $number->output());

        $number = Arithmatic
            ::make(10)
            ->when(
                true,
                function (Arithmatic $arithmatic) {
                    return $arithmatic->add(7);
                },
                function (Arithmatic $arithmatic) {
                    return $arithmatic->subtract(7);
                }
            );

        $this->assertEquals(17, $number->output());

        $number = Arithmatic
            ::make(10)
            ->when(
                false,
                function (Arithmatic $arithmatic) {
                    return $arithmatic->add(7);
                },
                100
            );

        $this->assertEquals(100, $number->output());
    }

    public function testItProvidesCommonAliasesForMethods()
    {
        $this->assertEquals(15, Arithmatic::start(5)->add(10)->output());
        $this->assertEquals(15, Arithmatic::start(5)->plus(10)->output());
        $this->assertEquals(15, Arithmatic::start(5)->sum(10)->output());

        $this->assertEquals(-5, Arithmatic::start(5)->subtract(10)->output());
        $this->assertEquals(-5, Arithmatic::start(5)->minus(10)->output());

        $this->assertEquals(10, Arithmatic::start(50)->div(5)->output());

        $this->assertEquals(250, Arithmatic::start(50)->times(5)->output());
        $this->assertEquals(250, Arithmatic::start(50)->x(5)->output());

        $this->assertEquals(5, Arithmatic::start([5, 5, 5])->avg()->output());
        $this->assertEquals(10, Arithmatic::start([5, 10, 15])->average()->output());
    }
}
