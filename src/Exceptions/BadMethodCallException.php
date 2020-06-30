<?php


namespace Devshed\Arithmatic\Exceptions;


use Exception;

class BadMethodCallException extends Exception
{
    /**
     * @param string $method
     *
     * @return BadMethodCallException
     */
    public static function badMethodCall(string $method)
    {
        return new static(sprintf('Call to undefined method [%s] on cascade', $method));
    }
}