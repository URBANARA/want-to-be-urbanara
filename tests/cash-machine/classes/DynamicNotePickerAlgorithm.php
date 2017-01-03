<?php

namespace CashMachine;

use \CashMachine\Interfaces\INotePickerAlgorithm;
use \CashMachine\Exceptions\NoteUnavailableException;
use \CashMachine\Exceptions\UndefinedNoteSetException;
use \CashMachine\Exceptions\InvalidArgumentException;

/**
* Contains the logic for sorting/picking out notes for withdraws request
* using Dynamic Function for optimal solution.
* @package  CashMachine
* @author   Walter Carrer Neto <carrer@gmail.com>
* @version  1.0
* @access   public
*/
class DynamicNotePickerAlgorithm implements INotePickerAlgorithm
{

    /**
    * Chooses the set of notes the ATM should dispose at a withdraw. This implementation uses Dynamic Function
    * to provide an optimal solution for the Coin Changing Problem. It's based on the algorithm provided at
    * https://www.dyclassroom.com/dynamic-programming/coin-changing-problem and illustrated at https://www.youtube.com/watch?v=rdI94aW6IWw.
    * It has O(An) complexity where n is the number of distinct notes available in the note set and A is the amount
    * of money required for withdraw.
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
    public function PickUpNotes($amount, $notesAvailable)
    {
        if ($notesAvailable == null) {
            throw new UndefinedNoteSetException();
        } elseif (!$amount) { // zero or null
            return new NoteSet([]);
        } elseif ($amount < 0) {
            throw new InvalidArgumentException();
        }

        $note = 0;
        $notesAvailableLength = sizeof($notesAvailable);
        $numNotes = array_fill(0, $amount+1, 0);
        $lastNote = array_fill(0, $amount+1, 0);

        for ($p = 1; $p <= $amount; $p++) {
            $min = PHP_INT_MAX;
            for ($i = 1; $i <= $notesAvailableLength; $i++) {
                if ($notesAvailable[$i-1]->note <= $p) {
                    if (1 + $numNotes[$p - $notesAvailable[$i-1]->note] < $min) {
                        $min = 1 + $numNotes[$p - $notesAvailable[$i-1]->note];
                        $note = $i;
                    }
                }
            }
            $numNotes[$p] = $min;
            $lastNote[$p] = $note;
        }


        if ($min == PHP_INT_MAX) { // infinite
            throw new NoteUnavailableException();
        }

        while ($amount > 0) {
            $obj = $notesAvailable[$lastNote[$amount]-1];
            if (isset($output[$obj->note])) {
                $output[$obj->note]++;
            } else {
                $output[$obj->note] = 1;
            }
            $amount -= $obj->note;
        }
        return new NoteSet($output);
    }
}
