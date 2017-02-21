<?php
namespace CashMachine\Contract;

interface CashMachineInterface
{
    public function withdraw(?float $amount) :array;
}
