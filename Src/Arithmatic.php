<?php

namespace Devshed\Arithmatic;


use Closure;
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
    public static function make($value)
    {
        return self::start($value);
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
     * Output the value
     *
     * @return int|float
     */
    public function output()
    {
        return $this->value;
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

        $this->value = ($this->value - $from) / abs($from) * 100;

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
     * @param mixed $condition
     * @param mixed $callable
     * @param mixed $fallback
     *
     * @return Arithmatic
     */
    public function when($condition, $callable, $fallback = null)
    {
        if ($condition instanceof Closure) {
            $condition = call_user_func($condition);
        }

        if (!$condition) {
            if (is_null($fallback)) {
                return $this;
            }

            return $this->run($fallback);
        }

        return $this->run($callable);
    }

    /**
     * @param $methods
     *
     * @return Arithmatic
     *
     * @throws BadMethodCallException
     */
    public function run($methods)
    {
        if ($methods instanceof Closure) {
            return call_user_func_array($methods, [$this]);
        }

        if (is_array($methods)) {
            foreach ($methods as $method => $argument) {
                $this->__call(
                    is_string($method) ? $method : $argument,
                    is_string($method) ? [$argument] : [],
                );
            }
        } else {
            $this->__call($methods, []);
        }

        return $this;
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
        $method = $this->getInternalMethod($name);

        return $this->$method(...$arguments);
    }

    /**
     * @param string $name
     *
     * @return string
     *
     * @throws \Devshed\Arithmatic\Exceptions\BadMethodCallException
     */
    protected function getInternalMethod($name)
    {
        if (method_exists($this, $name)) {
            return $name;
        }

        $method = 'call' . ucfirst($name);

        if (!method_exists($this, $method)) {
            throw BadMethodCallException::badMethodCall($name);
        }

        return $method;
    }
}