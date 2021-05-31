<?php

namespace Devshed\Arithmatic;

use Closure;
use Devshed\Arithmatic\Exceptions\BadMethodCallException;

/**
 * @method \Devshed\Arithmatic\Arithmatic percentageOf($value)
 * @method \Devshed\Arithmatic\Arithmatic percentageChange($value)
 * @method \Devshed\Arithmatic\Arithmatic divide($value)
 * @method \Devshed\Arithmatic\Arithmatic subtract($value)
 * @method \Devshed\Arithmatic\Arithmatic add($value)
 * @method \Devshed\Arithmatic\Arithmatic multiply($int)
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
     * @return \Devshed\Arithmatic\Arithmatic
     */
    public static function make($value)
    {
        return self::start($value);
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
     * @param Arithmatic|int|float $value
     *
     * @return \Devshed\Arithmatic\Arithmatic
     */
    public function callAdd($value)
    {
        $this->value = $this->getInternalValue() + (string) $value;

        return $this;
    }

    /**
     * @param Arithmatic|int|float $value
     *
     * @return \Devshed\Arithmatic\Arithmatic
     */
    public function callSubtract($value)
    {
        $this->value = $this->getInternalValue() - (string) $value;

        return $this;
    }

    /**
     * @param Arithmatic|int|float $by
     *
     * @return \Devshed\Arithmatic\Arithmatic
     */
    public function callDivide($by)
    {
        $this->value = $this->getInternalValue() / (string) $by;

        return $this;
    }

    /**
     * @param Arithmatic|int|float $from
     *
     * @return \Devshed\Arithmatic\Arithmatic
     */
    public function callPercentageChange($from)
    {
        $this->value = ($this->getInternalValue() - (string) $from) / abs((string) $from) * 100;

        return $this;
    }

    /**
     * @param Arithmatic|int|float $total
     *
     * @return \Devshed\Arithmatic\Arithmatic
     */
    public function callPercentageOf($total)
    {
        $this->value = $this->getInternalValue() / (string) $total * 100;

        return $this;
    }

    /**
     * @param Arithmatic|int|float $by
     *
     * @return \Devshed\Arithmatic\Arithmatic
     */
    public function callMultiply($by)
    {
        $this->value = $this->getInternalValue() * (string) $by;

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
        $this->value = round($this->getInternalValue(), $precision, $mode);

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
     * @param mixed $condition
     * @param mixed $callable
     * @param mixed $fallback
     *
     * @return \Devshed\Arithmatic\Arithmatic
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
     * @return \Devshed\Arithmatic\Arithmatic
     *
     * @throws BadMethodCallException
     */
    public function run($methods)
    {
        if ($methods instanceof Closure) {
            return call_user_func_array($methods, [$this]);
        }

        switch (true) {
            case is_array($methods):
                foreach ($methods as $method => $argument) {
                    $this->__call(
                        is_string($method) ? $method : $argument,
                        is_string($method) ? [$argument] : []
                    );
                }
                break;

            case is_string($methods):
                $this->__call($methods, []);
                break;

            case is_numeric($methods):
                $this->value = $methods;
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
     * @return string
     */
    public function __toString()
    {
        return (string) ($this->value instanceof Arithmatic ? $this->value->output() : $this->value);
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

    /**
     * @return float
     */
    protected function getInternalValue()
    {
        return floatval($this->__toString());
    }
}
