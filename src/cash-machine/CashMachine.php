<?php

namespace CashMachine;
use CashMachine\Contract\CashMachineInterface;
use CashMachine\Exception\NoteUnavailableException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

/**
 * Class CashMachine
 * @package CashMachine
 */
class CashMachine implements CashMachineInterface
{
    /**
     * @var array
     */
    private $availableNotes = [100.00, 50.00, 20.00, 10.00];

    /**
     * CashMachine constructor.
     */
    public function __construct()
    {
        // Sort available notes by desc
        rsort($this->availableNotes);
    }

    /**
     * Give notes as requested amount
     * @param float|null $amount
     * @return array
     */
    public function withdraw(?float $amount) :array {
        $givenNotes = [];
        // Return empty array if requested money is null
        if (!$amount) return $givenNotes;

        // Validate given amount and throw exception if needed
        $this->validateAmount($amount);

        foreach ($this->availableNotes as $availableNote) {
            $times = floor($amount/$availableNote);
            // If we need to give current available note, add it to given notes array
            if ($times>0) {
                // Use array_fill to add same item x times
                $givenNotes = array_merge($givenNotes, array_fill(0, $times, $availableNote));
                // New amount is remainder
                $amount = $amount % $availableNote;
            }
        }
        return $givenNotes;
    }

    /**
     * Validates given amount
     * @param float $amount
     * @return \Exception|null
     * @throws NoteUnavailableException
     */
    private function validateAmount(float $amount) :?\Exception {
        // If amount is negative or not numeric
        if ($amount < 0 || !is_numeric($amount))
            throw new InvalidArgumentException('You must give a positive number');

        // If there is no available notes as requested amount
        if ($amount % min($this->availableNotes) > 0)
            throw new NoteUnavailableException('No available notes as requested');

        return null;
    }

}