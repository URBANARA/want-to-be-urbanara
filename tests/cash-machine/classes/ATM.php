<?php

namespace CashMachine;

use \CashMachine\Exceptions\NotNotePickerAlgorithmException;

/**
* ATM represents an Automated Teller Machine.
*
* Although it isn't extended in the demo, this class should implement and control
* things like authenticating users, session management, perform and track withdraws
* among other maintenance and functional operations.
*
* @package  CashMachine
* @author   Walter Carrer Neto <carrer@gmail.com>
* @version  1.0
* @access   public
*/
final class ATM
{
    /**
   * @var NoteSet   $notes Available notes and their quantities in the ATM.
   * @var Class     $notePickerAlgorithm Which note picker algorithm the ATM will
   * use during withdraw requests
   */
   protected $notes;
    protected $notePickerAlgorithm;

    /**
   * Allows us to specify which note-picking algorithm will be used for withdraws
   * @access public
   * @var Class     $notePickerAlg Which class will be used on withdraw requests
   * @throws NotNotePickerAlgorithmException If $notePickerAlg doesn't implement
   * INotePickerAlgorithm interface
   */
    public function __construct($notePickerAlg=DynamicNotePickerAlgorithm::class)
    {
        if (!isset(class_implements($notePickerAlg)['CashMachine\Interfaces\INotePickerAlgorithm'])) {
            throw new NotNotePickerAlgorithmException();
        }

        $this->notePickerAlgorithm = new $notePickerAlg();
    }


    /**
    * Performs a withdraw and automatically deduce the amount taken from the balance
    *
    * @access public
    * @param  int       $amount     Amount of money requested
    * @return NoteSet               Set of notes taken
    * @throws NoteUnavailableException If it's not possible to compose the amount required
    * using notes available at the ATM.
    * @throws InvalidArgumentException When passing a negative $amount.
    * @throws UndefinedNoteSetException When RefilNotes has never been called.
    */
    public function PerformWithdraw(int $amount) : NoteSet
    {
        $notes = $this->notePickerAlgorithm->PickUpNotes($amount, $this->notes);
        $this->notes->Subtract($notes);
        return $notes;
    }

    /**
    * Refil the ATM's bills
    *
    * @access public
    * @param  NoteSet     $notes    Set of notes and their quantities
    */
    public function RefilNotes(NoteSet $notes)
    {
        $this->notes = $notes;
    }


    /**
    * Refil the ATM with notes
    *
    * @access public
    * @return  NoteSet              Set of notes available at the ATM and their quantities
    */
    public function GetBalance() : NoteSet
    {
        return $this->notes;
    }
}
