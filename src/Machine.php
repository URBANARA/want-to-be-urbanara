<?php

namespace Garbereder\Urbanara;

class Machine
{

    protected $notes = [];

    /**
     * Sets and sortes the given notes.
     * @param array $notes Array of avaiiable notes
     */
    public function setNotes(array $notes)
    {
        $this->notes = $notes;
        rsort($this->notes, SORT_NUMERIC);
    }

    /**
     * Calculates the set of notes to get the given withdraw
     * @param mixed $withdraw Amount to get from the machine
     * @return array of notes to get
     */
    public function withdraw($withdraw) : array
    {

        if ($withdraw == null) {
            return [];
        }

        if (!is_numeric($withdraw) || $withdraw < 0) {
            throw new \InvalidArgumentException();
        }

        return $this->calc($withdraw);
    }

    /**
     * Unchecked version of <code>withdraw</code> to do the calculation it self
     * @param mixed $withdraw Amount to get from the machine as int
     * @return array of notes to get
     * @throws NoteUnavailableException if the withdraw can not be given
     */
    private function calc($withdraw) : array
    {
        $returnNotes = [];
        foreach ($this->notes as $note) {
            if ($withdraw < $note) continue;

            $div = floor($withdraw / $note); // at least 1
            $returnNotes = array_merge($returnNotes, $this->fill($div, $note));
            $withdraw -= $div * $note;
        }


        // with a fixed amount of notes it could also be checked
        // by $withdraw % 10 != 0
        if ($withdraw > 0) {
            throw new NoteUnavailableException();
        }

        return $returnNotes;
    }

    /**
     * Fills an array with the given values the given time
     * @param mixed $amount Amount of instances to be added
     * @param mixed $value Object to be added
     * @return array of length $amount filled with $value objects
     */
    private function fill($amount, $value) : array
    {
        $filled = [];
        for ($i = 0; $i < $amount; ++$i) {
            $filled[] = $value;
        }
        return $filled;
    }

}
