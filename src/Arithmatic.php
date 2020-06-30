<?php

namespace Devshed\Arithmatic;

class Arithmatic
{
    protected $value;

    /**
     * Number constructor.
     *
     * @param int|float $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @param int|float $value
     *
     * @return \Devshed\Arithmatic\Arithmatic
     */
    public static function start($value)
    {
        return new self($value);
    }

    /**
     * @param int|float $value
     *
     * @return \Devshed\Arithmatic\Arithmatic
     */
    public static function make($value)
    {
        return self::start($value);
    }

    /**
     * @param int|float $int
     *
     * @return \Devshed\Arithmatic\Arithmatic
     */
    public function add($int)
    {
        $this->value += $int;

        return $this;
    }

    /**
     * @param int|float $int
     *
     * @return \Devshed\Arithmatic\Arithmatic
     */
    public function subtract($int)
    {
        $this->value -= $int;

        return $this;
    }

    /**
     * @param int|float $int
     *
     * @return \Devshed\Arithmatic\Arithmatic
     */
    public function divide($int)
    {
        $this->value /= $int;

        return $this;
    }

    /**
     * @param int|float $from
     *
     * @return \Devshed\Arithmatic\Arithmatic
     */
    public function percentageChange($from)
    {
        $this->value = ($this->value - $from) / $from * 100;

        return $this;
    }

    /**
     * @param int $precision
     * @param int $mode
     *
     * @return \Devshed\Arithmatic\Arithmatic
     */
    public function round(int $precision = 0, $mode = PHP_ROUND_HALF_UP)
    {
        $this->value = round($this->value, $precision, $mode);

        return $this;
    }

    /**
     * Output the value
     *
     * @return int|float
     */
    public function output()
    {
        return $this->value;
    }

    /**
     * Coerce the class value to a string
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->output();
    }
}