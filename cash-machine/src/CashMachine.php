<?php

namespace Urbanara;

use Urbanara\Exception\NoteUnavailableException;

/**
 * Class CashMachine
 * @package Urbanara
 */
class CashMachine
{
    /**
     * @var array
     */
    protected static $availableNotes = [10.00, 20.00, 50.00, 100.00];

    /**
     * @param float|null $money
     * @return array
     * @throws NoteUnavailableException
     */
    public static function out(?float $money): ?array
    {
        if ($money < 0) {
            throw new \InvalidArgumentException();
        }

        $notes = [];
        $balance = 0;
        usort(self::$availableNotes, function ($a, $b) {
            return ($a > $b) ? -1 : 1;
        });
        foreach (self::$availableNotes as $note) {
            $remainder = $money - $balance;
            $numberNote = 1;

            while ($numberNote) {
                if (($note * ($numberNote + 1)) > $remainder) {
                    break;
                }

                $numberNote++;
            }

            $result = $numberNote * $note;
            if (($balance + ($result)) <= $money) {
                $balance += $result;

                $notes = array_merge($notes, self::addNote($note, $numberNote));
            }
        }

        if ($balance != $money) {
            throw new NoteUnavailableException();
        }

        return $notes;
    }

    /**
     * @param float $note
     * @param int $number
     * @return array
     */
    protected static function addNote(float $note, int $number): array
    {
        $notes = [];
        while ($number > 0) {
            $notes[] = $note;

            $number--;
        }

        return $notes;
    }
}
