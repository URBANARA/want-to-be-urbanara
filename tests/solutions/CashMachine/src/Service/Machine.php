<?php

namespace Yatikh\CashMachine\Service;

use Yatikh\CashMachine\Exception\NoteUnavailableException;
use InvalidArgumentException;

/**
 * The class which will be simulate the delivery of notes from cash machine.
 * It's the solution for URBANARA developers test called "Cash Machine".
 *
 * @link https://github.com/URBANARA/want-to-be-urbanara/blob/master/tests/cash-machine.md
 * @author Yaroslav Tikhomirov <yartikh@gmail.com>
 */
class Machine
{
    /**
     * The default list of available notes.
     * @var array
     */
    protected $availableNotes = [100.0, 50.0, 20.0, 10.0];

    /**
     * The initialisation point of the machine.
     * We can put set of notes to the machine here.
     *
     * @param array $availableNotes Given list of available notes.
     */
    public function __construct(array $availableNotes = [])
    {
        if (!empty($availableNotes)) {
            rsort($availableNotes);
            $this->availableNotes = $availableNotes;
        }
    }

    /**
     * Get the list of available notes.
     *
     * @return array List of notes.
     */
    protected function getAvailableNotes()
    {
        return $this->availableNotes;
    }

    /**
     * Method which gives the notes to the client.
     *
     * @param  float $amount Amount of requested cash.
     * @return array         List of notes.
     *
     * @throws InvalidArgumentException If the amount not a positive float
     * @throws NoteUnavailableException If the amount can't be presented with current notes
     */
    public function getCash($amount)
    {
        if (is_null($amount)) {
            return [];
        }

        if (!is_numeric($amount) || $amount < 0) {
            throw new InvalidArgumentException("The machine doesn't have appropriate notes.");
        }

        $minNote = min($this->availableNotes);

        if ($amount % $minNote !== 0) {
            throw new NoteUnavailableException("The amount must be composable from available notes.");
        }

        $notes = [];

        while ($amount > 0) {
            foreach ($this->availableNotes as $note) {
                if ($amount - $note >= 0) {
                    $amount -= $note;
                    $notes[] = $note;
                    break;
                }
            }
        }

        return $notes;
    }
}