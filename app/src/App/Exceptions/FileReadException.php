<?php

/**
 * File read exception.
 */

namespace App\Exceptions;

/**
 * File not found exception.
 *
 * Thrown when an error occurs while reading from a file.
 */
class FileReadException extends \Exception
{
    /**
     * Constructor
     *
     * @see Exception::__construct().
     */
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        $message = 'Unable to read from ' . $message;
        parent::__construct($message, $code, $previous);
    }
}
