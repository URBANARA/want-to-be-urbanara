<?php
namespace CashMachine\Contract;

/**
 * Interface CashMachineInterface
 * @package CashMachine\Contract
 */
interface CashMachineInterface
{
    /**
     * @param float|null $amount
     * @return array
     */
    public function withdraw(?float $amount) :array;
}
