<?php

namespace Kix\Urbanara;

use Kix\Urbanara\CashWithdrawal\DenominationCollection;

class CashWithdrawal
{
    private $amount;

    private $availableDenominations;

    public function __construct(float $amount = null, array $denominations = [100.00, 50.00, 20.00, 10.00])
    {
        $this->availableDenominations = new DenominationCollection($denominations);

        if ($amount < 0) {
            throw new \InvalidArgumentException(sprintf(
                '`%s` is not a valid amount. Amount should be a positive number',
                $amount
            ));
        }
        
        if ($amount % $this->availableDenominations->min() > 0) {
            throw new NoteUnavailableException();
        }

        $this->amount = $amount;
    }

    public function execute() : array
    {
        $banknotes = [];
        $remainder = $this->amount;

        foreach ($this->availableDenominations as $amount) {
            while ($remainder >= $amount) {
                $banknotes []= $amount;
                $remainder -= $amount;
            }
        }

        return $banknotes;
    }
}
