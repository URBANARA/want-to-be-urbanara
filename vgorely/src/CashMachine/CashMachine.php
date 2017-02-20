<?php

namespace Urbanara\CashMachine;

use Urbanara\CashMachine\Exception\InvalidArgumentException;

class CashMachine
{
    /**
     * @var array
     */
    private $notes;

    /**
     * @param array $notes
     *
     * @throws InvalidArgumentException
     */
    public function __construct(array $notes)
    {
        if (!$notes) {
            throw new InvalidArgumentException();
        }

        foreach ($notes as $availableNote) {
            if (filter_var($availableNote, FILTER_VALIDATE_INT) === false || $availableNote <= 0) {
                throw new InvalidArgumentException();
            }
        }

        $this->notes = $notes;
    }

    /**
     * @return array
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @return array
     */
    public function getNotesDesc()
    {
        $notes = $this->getNotes();
        rsort($notes);

        return $notes;
    }
}