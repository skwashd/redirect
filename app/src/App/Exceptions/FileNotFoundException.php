<?php

/**
 * File not found exception.
 */

namespace App\Exceptions;

/**
 * File not found exception.
 *
 * Thrown when a file doesn't exist or isn't readable.
 */
class FileNotFoundException extends \Exception
{
    /**
     * Constructor
     *
     * @see Exception::__construct().
     */
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        $code = 404;
        $message = 'File not found ' . $message;
        parent::__construct($message, $code, $previous);
    }
}
