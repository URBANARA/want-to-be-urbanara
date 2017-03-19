<?php
declare(strict_types=1);

namespace Usama;

/**
 * Cache Machine implementation
 */
class CacheMachine
{
    /** @var array */
    protected $available_notes = [100, 50, 20, 10];

    /**
     * A class constructor
     *
     * @param array $available_notes Custom notes array
     */
    public function __construct(array $available_notes = [])
    {
        if (!empty($available_notes)) {
            $available_notes = array_map('floatval', $available_notes);
            $available_notes = array_filter($available_notes, function ($x) {return $x > 0;});
            if (!empty($available_notes)) {
                rsort($available_notes);
                $this->available_notes = $available_notes;
            }
        }
    }

    /**
     * Method for getting available notes
     * It uses in tests
     *
     * @return array
     */
    public function getAvailableNotes() : array
    {
        return $this->available_notes;
    }


    /**
     * Method for calculate numbers of notes
     *
     * @param int $amount
     * @return array
     * @throws NoteUnavailableException
     */
    public function withdraw($amount) : array
    {
        if (empty($amount)) {
            return [];
        }
        if ((int)$amount < 0) {
            throw new \InvalidArgumentException('Amount should be a positive number');
        }

        $result = [];

        foreach ($this->available_notes as $note) {
            $note_count = (int)floor($amount / $note);
            $amount -= $note*$note_count;
            $result = array_pad($result, count($result) + $note_count, $note);
        }

        if ($amount > 0) {
            throw new NoteUnavailableException();
        }

        return $result;
    }
}