<?php

namespace Urbanara\CashMachine\Service;

use Urbanara\CashMachine\Entity\CurrencyNote;
use Urbanara\CashMachine\Exception\NoteUnavailableException;
use Urbanara\CashMachine\Factory\AbstractCurrencyNoteFactory;

/**
 * @author Alexandre Rodrigues Xavier <alexandre.rodrigues.xv@gmail.com>
 *
 * @package Urbanara\CashMachine\Service
 */
class CashMachine
{
    /**
     * @var \Urbanara\CashMachine\Entity\CurrencyNote[]
     */
    private $availableCurrencyNotes = [];

    /**
     * @var \Urbanara\CashMachine\Service\LowestAmountPossibleCalculator
     */
    private $calculator;

    /**
     * CashMachine constructor.
     *
     * @param \Urbanara\CashMachine\Service\LowestAmountPossibleCalculator $calculator
     * @param \Urbanara\CashMachine\Factory\AbstractCurrencyNoteFactory    $currencyNoteFactory
     */
    public function __construct(
        LowestAmountPossibleCalculator $calculator,
        AbstractCurrencyNoteFactory $currencyNoteFactory
    ) {
        $this->availableCurrencyNotes = $currencyNoteFactory->getAvailableCurrencyNotes();
        $this->calculator = $calculator;
    }

    /**
     * @param float $amount
     *
     * @return float[]
     *
     * @throws \Urbanara\CashMachine\Exception\NoteUnavailableException
     */
    public function withdraw($amount)
    {
        if (empty($amount)) {
            return [];
        }

        $notes = $this->getNotesToWithdraw($amount);

        $distribution = $this->calculator->findLowestDistribution(
            $amount,
            $this->convertNotesToArray($notes)
        );

        if ([] == $distribution) {
            throw new NoteUnavailableException('Unable to withdraw');
        }

        return $distribution;
    }

    /**
     * @param \Urbanara\CashMachine\Entity\CurrencyNote[] $notes
     *
     * @return float[]
     */
    private function convertNotesToArray(array $notes)
    {
        $divisors = [];

        foreach ($notes as $note) {
            $divisors[] = $note->getValue();
        }

        return $divisors;
    }

    /**
     * @param float $amount
     *
     * @return \Urbanara\CashMachine\Entity\CurrencyNote[]
     */
    private function getNotesToWithdraw($amount)
    {
        return array_filter(
            $this->availableCurrencyNotes,
            function (CurrencyNote $note) use ($amount) {
                return $note->getValue() <= $amount;
            }
        );
    }
}
