<?php

namespace Devshed\Arithmatic\Tests;

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
    }
}