<?php

namespace Urbanara\CashMachine;

use Urbanara\CashMachine\Exception\NoteUnavailableException;
use \InvalidArgumentException;

class CashMachine implements CashMachineInterface
{
    /**
     * @var \Urbanara\CashMachine\Banknotes
     */
    private $banknotes;

    /**
     * @var array
     */
    private $withdrawBanknotes = array();

    public function __construct(Banknotes $banknotes)
    {
        $this->banknotes = $banknotes;
    }

    /**
     * Withdraw some money
     *
     * @param float
     *
     * @return array
     */
    public function execute($value)
    {
        $this->validateValue($value);
        $this->verifyAvailability($value);

        while ($value > 0) {
            $this->banknotes->filterMaxValue($value);

            $banknote = $this->banknotes->getGreater();
            $this->withdrawBanknotes[] = $banknote;
            $value -= $banknote;
        }

        return $this->withdrawBanknotes;
    }

    /**
     * Validate value passed to withdraw
     *
     * @param float $value
     */
    private function validateValue($value)
    {
        if ($value != null && $value <= 0) {
            throw new InvalidArgumentException('The value is not acceptable.');
        }
    }

    /**
     * Verify if is notes available to withdraw in CashMachine
     *
     * @param float $value
     */
    private function verifyAvailability($value)
    {
        $filtered = array_filter(
            $this->banknotes->getBanknotes(),
            function ($note) use ($value) {
                return ($value % $note === 0);
            }
        );

        if (count($filtered) == 0) {
            throw new NoteUnavailableException('Note not available for this value.');
        }
    }
}
