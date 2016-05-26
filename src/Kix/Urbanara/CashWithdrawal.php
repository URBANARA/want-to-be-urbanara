<?php

namespace Kix\Urbanara;

class CashWithdrawal
{
    private $amount;

    private $availableDenominations;

    public function __construct(float $amount = null, array $denominations = [100.00, 50.00, 20.00, 10.00])
    {
        sort($denominations);
        $this->availableDenominations = array_reverse($denominations);

        if ($amount % min($this->availableDenominations) > 0) {
            throw new NoteUnavailableException();
        }

        if ($amount < 0) {
            throw new \InvalidArgumentException(sprintf(
                '`%s` is not a valid amount. Amount should be a positive number',
                $amount
            ));
        }

        $this->amount = (float) $amount;
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
