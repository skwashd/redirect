<?php

/**
 * File write exception.
 */

namespace App\Exceptions;

/**
 * File not found exception.
 *
 * Thrown when an error occurs while writing to a file.
 */
class FileWriteException extends \Exception
{
    /**
     * Constructor
     *
     * @see Exception::__construct().
     */
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        $message = 'Unable to write to ' . $message;
        parent::__construct($message, $code, $previous);
    }
}
