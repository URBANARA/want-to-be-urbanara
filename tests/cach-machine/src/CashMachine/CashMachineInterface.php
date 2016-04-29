<?php

namespace Urbanara\CashMachine;

interface CashMachineInterface
{

    /**
     * @param float $input
     * @return array
     */
    public function execute($input);
}
