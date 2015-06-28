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
class DataNotLoadedException extends \Exception
{
    /**
     * Constructor
     *
     * @see Exception::__construct().
     */
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        $message = 'Site data not loaded';
        parent::__construct($message, $code, $previous);
    }
}
