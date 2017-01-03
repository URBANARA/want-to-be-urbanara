<?php

namespace CashMachine\Exceptions;

/**
* NotNotePickerAlgorithmException is thrown when a class that doesn't
* implement the INotePickerAlgorithm interface is passed at the ATM
* constructor.
**
* @package  CashMachine\Exceptions
* @author   Walter Carrer Neto <carrer@gmail.com>
* @version  1.0
* @access   public
*/
class NotNotePickerAlgorithmException extends \Exception
{

}
