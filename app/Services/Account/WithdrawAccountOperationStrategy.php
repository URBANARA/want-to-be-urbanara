<?php

namespace App\Services\Account;

use App\Services\Account\Contracts\AccountOperationStrategyInterface;
use App\Services\Account\Contracts\AvailableBankNotesInterface;
use App\Services\Account\Exceptions\NoteUnavailableException;
use App\Services\Account\Exceptions\InvalidArgumentException;
use Illuminate\Http\Request;

class WithdrawAccountOperationStrategy implements AccountOperationStrategyInterface
{
    /**
     * Index to accesss cash value from Request
     * @var string
     */
    const REQUEST_CASH_INDEX = 'cash';

    /**
     * @var Illuminate\Http\Request
     */
    private $request;

    /**
     * [$banknotes BankNotes array ]
     * @var App\Services\Account\Contracts\AvailableBankNotesInterface
     */
    private $banknotesManager;

    /**
     * [__construct]
     * @param Request $request
     */
    public function __construct(Request $request, AvailableBankNotesInterface $banknotesManager)
    {
        $this->request = $request;
        $this->banknotesManager = $banknotesManager;
    }

    /**
     * [processOperation Execute the operation requested by user]
     * @throws InvalidArgumentException if $cash is less than 0
     * @throws NoteUnavailableException if division by available bank notes has remainders
     * @return array
     */
    public function processOperation()
    {
        $cash = $this->request->input(self::REQUEST_CASH_INDEX);

        return $this->calculeteBankNotes($cash);
    }

    /**
     * [calculeteBankNotes returns an array with bank notes on indexes and quantity of notes as value]
     * @param  [int|float] $cash
     * @throws InvalidArgumentException if $cash is less than 0
     * @throws NoteUnavailableException if division by available bank notes has remainders
     * @return array
     */
    private function calculeteBankNotes($cash)
    {
        if ($cash < 0) {
            throw new InvalidArgumentException(
                "The amount requested can not be less than zero"
            );
        }

        $map = [];
        $banknotesValues = $this->banknotesManager->getValuesFromBankNotes();

        foreach ($banknotesValues as $banknotesValue) {
            $max = max($banknotesValues);
            $banknotesValues = array_diff($banknotesValues, [$max]);
            $quantity = (int) ($cash / $max);
            $map[$max] = $quantity;
            $cash = $cash - ($max * $quantity);
        }

        if ($cash) {
            throw new NoteUnavailableException(
                "There are no bank notes available to make up the amount requested"
            );
        }

        return $map;
    }
}
