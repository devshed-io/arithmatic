<?php

use Devshed\Arithmatic\Arithmatic;

it('starts with an integer', function () {
    assertEquals(5, Arithmatic::start(5)->output());
    assertEquals(10, Arithmatic::make(10)->output());
});

it('provides an output', function () {
    $number = new Arithmatic(5);

    assertTrue(method_exists($number, 'output'));
});


it('performs addition', function () {
    $number = Arithmatic
        ::start(5)
        ->add(5);

    assertEquals(10, $number->output());
});

it('performs subtraction', function () {
    $number = Arithmatic
        ::start(5)
        ->subtract(2);

    assertEquals(3, $number->output());
});

it('performs division', function () {
    $number = Arithmatic::start(5)->divide(2);

    assertEquals(2.5, $number->output());
});

it('performs percentage change', function () {
    $number = Arithmatic::start(100)->percentageChange(80);

    assertEquals(25.0, $number->output());

    $number = Arithmatic::start(100)->percentageChange(125);

    assertEquals(-20.0, $number->output());
});

it('performs rounding', function () {
    $number = Arithmatic::start(1.5)->round();

    assertEquals(2.0, $number->output());
});

it('can be coerced to the expected output', function () {
    $number = Arithmatic::start(10);

    assertEquals(10, (string) $number);
});