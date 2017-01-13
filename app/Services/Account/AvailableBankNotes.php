<?php

namespace App\Services\Account;

use App\Services\Account\Contracts\AvailableBankNotesInterface;

class AvailableBankNotes implements AvailableBankNotesInterface
{
    /**
     * [$availableBankNotes shows all available bank notes]
     * @var [array]
     */
    private $availableBankNotes = [10, 20, 50, 100];

    /**
     * [getValuesFromBankNotes]
     * @return array
     */
    public function getValuesFromBankNotes()
    {
        return $this->availableBankNotes;
    }
}
