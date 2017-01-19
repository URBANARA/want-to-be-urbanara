<?php

namespace CashMachine\Exceptions;

/**
* NoteUnavailableException represents events where the ATM can not
* compose the amount of money required in a withdraw using the set
* of notes currently available in it.
**
* @package  CashMachine\Exceptions
* @author   Walter Carrer Neto <carrer@gmail.com>
* @version  1.0
* @access   public
*/
class NoteUnavailableException extends \Exception
{

}
