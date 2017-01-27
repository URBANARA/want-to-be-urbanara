<?php namespace AppExceptions;


class NoteUnavailableException extends \Exception
{
    public function __construct( $message = "" )
    {
        parent::__construct($message, 400);
    }
}