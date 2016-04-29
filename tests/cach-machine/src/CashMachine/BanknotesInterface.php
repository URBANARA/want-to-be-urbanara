<?php
/**
 * Created by PhpStorm.
 * User: felipegirotti
 * Date: 4/29/16
 * Time: 8:16 PM
 */

namespace Urbanara\CashMachine;


interface BanknotesInterface
{
    /**
     * Set banknotes
     *
     * @param array $banknotes
     */
    public function setBanknotes(array $banknotes);

    /**
     * Get banknotes
     *
     * @return array
     */
    public function getBanknotes();

    /**
     * Filter max value to banknotes
     *
     * @param float $max
     */
    public function filterMaxValue($max);

    /**
     * Get grater banknote
     *
     * @return float|int
     */
    public function getGreater();
}