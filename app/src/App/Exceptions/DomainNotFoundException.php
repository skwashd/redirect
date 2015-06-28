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
class DomainNotFoundException extends \Exception
{
    /**
     * Constructor
     *
     * @see Exception::__construct().
     */
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        $code = 404;
        $message = 'Domain not found ' . $message;
        parent::__construct($message, $code, $previous);
    }
}
