<?php

namespace Urbanara\CashMachine;

class Banknotes implements BanknotesInterface
{

    /**
     * Banknotes available
     *
     * @var array
     */
    private $banknotes = array(10, 20, 50, 100);

    /**
     * Set banknotes
     *
     * @param array $banknotes
     */
    public function setBanknotes(array $banknotes)
    {
        $this->banknotes = $banknotes;
    }

    /**
     * Get banknotes
     *
     * @return array
     */
    public function getBanknotes()
    {
        return $this->banknotes;
    }

    /**
     * Filter max value to banknotes
     *
     * @param float $max
     */
    public function filterMaxValue($max)
    {
        $this->banknotes = array_filter(
            $this->banknotes,
            function ($var) use ($max) {
                return ($var <= $max);
            }
        );
    }

    /**
     * Get grater banknote
     *
     * @return float|int
     */
    public function getGreater()
    {
        $this->descSort();

        return max($this->banknotes);
    }

    /**
     * Get note values desc sorted
     *
     * @return void
     */
    private function descSort()
    {
        rsort($this->banknotes);
    }
}
