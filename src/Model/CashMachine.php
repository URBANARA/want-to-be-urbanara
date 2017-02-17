<?php
/**
 * @author Ondrej Führer <ondrej@fuhrer.cz>
 * @date 16.2.2017 14:01
 */

namespace Model;

use Exception\NoteUnavailableException;

/**
 * Class CashMachine
 * @package Model
 */
class CashMachine implements CashMachineInterface
{
    /**
     * @var float[]
     */
    private $availableNotes = [100.0, 50.0, 20.0, 10.0];

    /**
     * @inheritdoc
     */
    public function withdraw(float $amount = null): array
    {
        if (0 > $amount) {
            throw new \InvalidArgumentException();
        }

        if (!$amount) {
            return [];
        }

        $lowestNote = $this->availableNotes[count($this->availableNotes) - 1];
        if ($amount % $lowestNote > 0 || $amount < $lowestNote) {
            throw new NoteUnavailableException();
        }

        $result = [];

        while ($amount > 0) {
            $note = $this->findNote($amount);
            if (!$note) {
                throw new NoteUnavailableException();
            }

            $result[] = $note;
            $amount -= $note;
        }

        return $result;
    }

    /**
     * @param float $amount
     * @return float|null
     */
    private function findNote(float $amount)
    {
        foreach ($this->availableNotes as $position => $note) {
            if ($amount >= $note) {
                return $note;
            }
        }

        return null;
    }
}
