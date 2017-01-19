<?php

namespace CashMachine\Interfaces;

/**
* INotePickerAlgorithm contains the logic for sorting/picking out notes for
* withdraws performed at an ATM
**
* @package  CashMachine\Interfaces
* @author   Walter Carrer Neto <carrer@gmail.com>
* @version  1.0
* @access   public
*/
interface INotePickerAlgorithm
{
    /**
    * Chooses the set of notes the ATM should dispose at a withdraw
    *
    * @param  string  $amount           Amount of money required to withdraw
    * @param  NoteSet $notesAvailable   Set of notes, and their quantities, currently available in the ATM.
    * @return NoteSet                   Set of notes, and their quantities, the ATM must withdraw.
    * @access public
    * @throws NoteUnavailableException If it's not possible to compose the amount required
    * using notes available.
    * @throws InvalidArgumentException When passing a negative $amount.
    * @throws UndefinedNoteSetException When the ATM NoteSet has not been initialized.
    */
    public function PickUpNotes($amount, $notesAvailable);
}
