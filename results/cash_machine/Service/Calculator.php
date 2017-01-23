<?php
/**
 * User: Oleksii Polishchuk
 * Date: 22.05.2016
 */

namespace CashMachine\Service;


use CashMachine\Exception\NoteUnavailableException;

/**
 * Class Calculator
 * @package CashMachine\Service
 */
class Calculator
{
    protected $nominals;

    protected $amount;

    public function __construct($amount, $nominals)
    {
        $this->setAmount($amount);
        $this->setNominals($nominals);
    }

    public function calculate()
    {
        $result = $this->getCombinations($this->getAmount(), $this->getNominals());

        if (array_sum($result) != $this->getAmount()) {
            throw new NoteUnavailableException("Unable to return required amount: ". $this->getAmount());
        }

        return $result;
    }

    protected function getCombinations($amount, array $nominals)
    {
        $remaining = $amount;
        $combinations = array();
        $value = array_shift($nominals);
        if (!is_null($value)) {
            if ($value <= $remaining) {
                $qty = floor($remaining / $value);
                $remaining = $remaining - ($qty * $value);
                $combinations = array_fill(0, $qty, $value);
            }

            if ($remaining > 0) {
                $result = $this->getCombinations($remaining, $nominals);
                $combinations = array_merge($combinations, $result);
            }
        }

        return $combinations;
    }

    /**
     * @return mixed
     */
    public function getNominals()
    {
        return $this->nominals;
    }

    /**
     * @param array $nominals
     */
    public function setNominals(array $nominals)
    {
        rsort($nominals);
        $this->nominals = $nominals;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }


}