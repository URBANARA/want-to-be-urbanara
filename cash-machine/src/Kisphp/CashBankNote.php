<?php

namespace Kisphp;

class CashBankNote implements CashBankNoteInterface
{
    /**
     * @var int
     */
    protected $amount;

    /**
     * @param int $amount
     */
    public function __construct($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return number_format($this->amount, 2);
    }
}
