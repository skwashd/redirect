<?php

/**
 * Invalid JSON exception.
 */

namespace App\Exceptions;

/**
 * Invalid JSON exception.
 *
 * Thrown when parsing a JSON string or file fails.
 */
class InvalidJsonException extends \Exception
{
    /**
     * Constructor
     *
     * @see Exception::__construct().
     */
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        $message = 'Unable to parse JSON in ' . $message;
        parent::__construct($message, $code, $previous);
    }
}
