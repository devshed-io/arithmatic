<?php

namespace Devshed\Arithmatic;


use Devshed\Arithmatic\Exceptions\BadMethodCallException;

/**
 * @method Arithmatic percentageChange($value)
 * @method Arithmatic divide($value)
 * @method Arithmatic subtract($value)
 * @method Arithmatic add($value)
 * @method Arithmatic multiply($int)
 */
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
     * @return Arithmatic
     */
    public static function start($value)
    {
        return new self($value);
    }

    /**
     * @param int|float $value
     *
     * @return Arithmatic
     */
    public static function make($value)
    {
        return self::start($value);
    }

    /**
     * @param Arithmatic|int|float $value
     *
     * @return Arithmatic
     */
    public function callAdd($value)
    {
        if ($value instanceof Arithmatic) { // Todo: Piped call ?
            $value = $value->output();
        }

        $this->value += $value;

        return $this;
    }

    /**
     * @param Arithmatic|int|float $value
     *
     * @return Arithmatic
     */
    public function callSubtract($value)
    {
        if ($value instanceof Arithmatic) { // Todo: Piped call ?
            $value = $value->output();
        }

        $this->value -= $value;

        return $this;
    }

    /**
     * @param Arithmatic|int|float $by
     *
     * @return Arithmatic
     */
    public function callDivide($by)
    {
        if ($by instanceof Arithmatic) { // Todo: Piped call ?
            $by = $by->output();
        }

        $this->value /= $by;

        return $this;
    }

    /**
     * @param Arithmatic|int|float $from
     *
     * @return Arithmatic
     */
    public function callPercentageChange($from)
    {
        if ($from instanceof Arithmatic) { // Todo: Piped call ?
            $from = $from->output();
        }

        $this->value = ($this->value - $from) / $from * 100;

        return $this;
    }

    /**
     * @param Arithmatic|int|float $by
     *
     * @return Arithmatic
     */
    public function callMultiply($by)
    {
        if ($by instanceof Arithmatic) { // Todo: Piped call ?
            $by = $by->output();
        }

        $this->value = $this->value * $by;

        return $this;
    }

    /**
     * @param int $precision
     * @param int $mode
     *
     * @return Arithmatic
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
     * @param $name
     * @param $arguments
     *
     * @return mixed
     *
     * @throws BadMethodCallException
     */
    public function __call($name, $arguments)
    {
        $method = 'call' . ucfirst($name);

        if (method_exists($this, $method)) {
            return $this->$method(...$arguments);
        }

        throw BadMethodCallException::badMethodCall($name);
    }
}