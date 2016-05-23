<?php

namespace Kisphp;

abstract class CashFactory
{
    /**
     * @return CashMachine
     */
    public static function createCashMachine()
    {
        $cashMachine = new CashMachine();
        $cashMachine->registerBankNote(new CashBankNote(10));
        $cashMachine->registerBankNote(new CashBankNote(20));
        $cashMachine->registerBankNote(new CashBankNote(50));
        $cashMachine->registerBankNote(new CashBankNote(100));

        return $cashMachine;
    }
}