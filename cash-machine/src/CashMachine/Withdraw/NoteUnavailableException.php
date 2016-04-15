<?php
declare(strict_types=1);

namespace CashMachine\Withdraw;

use Exception;

class NoteUnavailableException extends Exception
{
    private $unavailableNote;

    public function __construct(int $unavailableNote, string $msg = null, int $code = 0, Throwable $previous = null)
    {
        $this->unavailableNote = $unavailableNote;
        return parent::__construct($msg, $code, $previous);
    }



    /**
     * Gets the value of unavailableNote.
     *
     * @return mixed
     */
    public function getUnavailableNote()
    {
        return $this->unavailableNote;
    }

    /**
     * Sets the value of unavailableNote.
     *
     * @param mixed $unavailableNote the unavailable note
     *
     * @return self
     */
    public function setUnavailableNote($unavailableNote)
    {
        $this->unavailableNote = $unavailableNote;

        return $this;
    }
}
