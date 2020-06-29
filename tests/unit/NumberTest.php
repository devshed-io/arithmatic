<?php

use Devshed\Arithmatic\Number;

it('starts with an integer', function () {
    $number = new Number(5);

    assertEquals(5, $number->value);
    assertIsInt($number->value);
});

it('performs addition', function () {
    $number = new Number(5);

    $number->add(5);

    assertEquals(10, $number->value);
});

it('performs subtraction', function () {
    $number = new Number(5);

    $number->subtract(2);

    assertEquals(3, $number->value);
});