<?php

/**
 * Created by PhpStorm.
 * User: amiralijiwani
 * Date: 12/06/2016
 * Time: 11:42 PM
 */

namespace AppCode\InputOutput;

use AppCode\Note\INote;

class CashMachineResponse
{
    private $amount;
    private $noteItems;

    public function __construct($amount)
    {
        $this->amount = $amount;
        $this->noteItems = [];
    }

    private function DeductAmount($partialAmount)
    {
        if ($partialAmount <= $this->amount)
        {
            $this->amount -= $partialAmount;
        }
    }

    public function isAmountConsumed()
    {
        return ($this->amount === 0);
    }

    public function AddNote(INote $note)
    {
        $this->DeductAmount($note->GetNoteValue());
        $this->noteItems[] = $note;
    }

    public function GetAmount()
    {
        return $this->amount;
    }

    public function GetNotes()
    {
        return $this->noteItems;
    }
}