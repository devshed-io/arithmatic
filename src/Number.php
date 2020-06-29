<?php

namespace Devshed\Arithmatic;

class Number
{
    public $value;

    /**
     * Number constructor.
     *
     * @param int $value
     */
    public function __construct(int $value)
    {
        $this->value = $value;
    }

    /**
     * @param int $int
     *
     * @return $this
     */
    public function add(int $int)
    {
        $this->value += $int;

        return $this;
    }

    /**
     * @param int $int
     *
     * @return $this
     */
    public function subtract(int $int)
    {
        $this->value -= $int;

        return $this;
    }
}