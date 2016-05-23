<?php

namespace Kisphp;

use Kisphp\Exceptions\InvalidArgumentException;
use Kisphp\Exceptions\NoteUnavailableException;

class CashMachine
{
    /**
     * @var array
     */
    protected $availableBankNotes = [];

    /**
     * @param CashBankNoteInterface $bankNote
     *
     * @return $this
     */
    public function registerBankNote(CashBankNoteInterface $bankNote)
    {
        $this->availableBankNotes[$bankNote->getAmount()] = $bankNote;

        return $this;
    }

    /**
     * @param int|null $amount
     *
     * @throws InvalidArgumentException
     * @throws NoteUnavailableException
     *
     * @return array|null
     */
    public function withdraw($amount)
    {
        if ($amount === null) {
            return null;
        }

        if ($amount <= 0) {
            throw new InvalidArgumentException;
        }

        $availableBankNotes = $this->getAvailableBankNotes();

        $resultBankNotes = [];

        /** @var CashBankNoteInterface $cashNote */
        foreach ($availableBankNotes as $cashNote) {
            if ($cashNote->getAmount() > $amount) {
                continue;
            }

            // how many banknotes of this type
            $number = (int) floor($amount / $cashNote->getAmount());

            // add banknote type and number to be returned
            $resultBankNotes[$cashNote->getAmount()] = $number;

            // extract registered sum from required amount
            $amount -= $number * $cashNote->getAmount();
        }

        if ($amount != 0) {
            throw new NoteUnavailableException();
        }

        return $resultBankNotes;
    }

    /**
     * @return array
     */
    protected function getAvailableBankNotes()
    {
        krsort($this->availableBankNotes);

        return $this->availableBankNotes;
    }
}
