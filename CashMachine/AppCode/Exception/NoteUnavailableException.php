<?php

/**
 * Created by PhpStorm.
 * User: amiralijiwani
 * Date: 13/06/2016
 * Time: 12:05 AM
 */

namespace AppCode\Exception;

class NoteUnavailableException extends \Exception
{
    // Redefine the exception so message isn't optional
    public function __construct($message, $code = 0, Exception $previous = null) {
        // some code

        // make sure everything is assigned properly
        parent::__construct($message, $code, $previous);
    }

    // custom string representation of object
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}