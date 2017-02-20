<?php

namespace Urbanara\CashMachine;

use Urbanara\CashMachine\Exception\InvalidArgumentException;
use Urbanara\CashMachine\Exception\NoteUnavailableException;

class CashWithdrawal
{
    /**
     * @var CashMachine
     */
    private $cashMachine;

    /**
     * @param CashMachine $cashMachine
     */
    public function __construct(CashMachine $cashMachine)
    {
        $this->cashMachine = $cashMachine;
    }

    /**
     * @param int $amount
     * @return array
     *
     * @throws InvalidArgumentException
     * @throws NoteUnavailableException
     */
    public function withdraw($amount)
    {
        if ($amount === null) {
            $amount = 0;
        }

        if (filter_var($amount, FILTER_VALIDATE_INT) === false || $amount < 0) {
            throw new InvalidArgumentException();
        }

        $notes = $this->cashMachine->getNotesDesc();

        $lowestNote = $notes[count($notes) - 1];
        if ($amount % $lowestNote !== 0) {
            throw new NoteUnavailableException();
        }

        $returnedNotes = [];
        foreach ($notes as $note) {
            $number = floor($amount / $note);

            $returnedNotes = array_merge(
                $returnedNotes,
                array_fill(0, $number, $note)
            );

            $amount -= $number * $note;
            if (!$amount) {
                break;
            }
        }

        return $returnedNotes;
    }
}
